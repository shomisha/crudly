<?php

namespace Shomisha\Crudly\Test\Unit\Developers\ApiCrud;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Api\FormRequest\ApiFormRequestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ApiFormRequestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_api_form_request()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('title', ModelPropertyType::STRING())
                ->unique()
            ->property('body', ModelPropertyType::TEXT())
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author');


        $manager = new FormRequestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ApiFormRequestDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $formRequest = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(ClassTemplate::class, $formRequest);
        $this->assertEquals($developedSet->getApiCrudFormRequest(), $formRequest);

        $printedFormRequest = $formRequest->print();
        $this->assertStringContainsString("namespace App\Http\Requests\Api;", $printedFormRequest);
        $this->assertStringContainsString("use Illuminate\Foundation\Http\FormRequest;", $printedFormRequest);
        $this->assertStringContainsString("use Illuminate\Validation\Rule;", $printedFormRequest);

        $this->assertStringContainsString(implode("\n", [
            "class PostRequest extends FormRequest",
            "{",
            "    public function rules()",
            "    {",
            "        \$titleUniqueRule = Rule::unique('posts', 'title');",
            "        \$authorIdExistsRule = Rule::exists('authors', 'id');",
            "        \$post = \$this->route('post');",
            "        if (\$post) {",
            "            \$titleUniqueRule->ignore(\$post->id);",
            "        }\n",
            "        return ['title' => [\$titleUniqueRule, 'required', 'string', 'max:255'], 'body' => ['required', 'string', 'max:65535'], 'author_id' => [\$authorIdExistsRule, 'required', 'integer']];",
            "    }",
            "}",
        ]), $printedFormRequest);
    }

    /** @test */
    public function developer_will_delegate_methods_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->methodDevelopers([
            'getAuthorizeMethodDeveloper',
            'getRulesMethodDeveloper',
        ]);


        $developer = new ApiFormRequestDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertMethodDeveloperRequested('getAuthorizeMethodDeveloper');
        $this->manager->assertMethodDeveloperRequested('getRulesMethodDeveloper');
    }
}
