<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\ArrayDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules\RulesMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class RulesMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_the_form_request_rules_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->isForeign('id', 'countries');


        $manager = new FormRequestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new RulesMethodDeveloper($manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $method);

        $formRequest = ClassTemplate::name('FormRequest')->addMethod($method);
        $this->assertStringContainsString(implode("\n", [
            "    public function rules()",
            "    {",
            "        \$emailUniqueRule = Rule::unique('authors', 'email');",
            "        \$countryIdExistsRule = Rule::exists('countries', 'id');",
            "        \$author = \$this->route('author');",
            "        if (\$author) {",
            "            \$emailUniqueRule->ignore(\$author->id);",
            "        }\n",

            "        return ['email' => [\$emailUniqueRule, 'required', 'email'], 'name' => ['required', 'string', 'max:255'], 'country_id' => [\$countryIdExistsRule, 'required', 'integer']];",
            "    }"
        ]), $formRequest->print());
    }

    /** @test */
    public function developer_will_delegate_rules_development_to_other_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->isForeign('id', 'countries');

        $this->manager->imperativeCodeDevelopers([
            'getSpecialRulesDeveloper',
        ])->valueDevelopers([
            'getValidationRulesDeveloper',
        ]);

        $this->manager->useValueDeveloper(new ArrayDeveloper());


        $developer = new RulesMethodDeveloper($this->manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getSpecialRulesDeveloper');
        $this->manager->assertValueDeveloperRequested('getValidationRulesDeveloper');
    }
}
