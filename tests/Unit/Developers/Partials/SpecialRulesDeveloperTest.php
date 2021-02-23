<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules\SpecialRulesDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class SpecialRulesDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_special_rules()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('title', ModelPropertyType::STRING())
                ->unique()
            ->property('category_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'categories');


        $developer = new SpecialRulesDeveloper($this->manager, $this->modelSupervisor);
        $specialRules = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $specialRules);

        $printedRules = $specialRules->print();
        $this->assertStringContainsString("use Illuminate\Validation\Rule;", $printedRules);

        $this->assertStringContainsString(implode("\n", [
            "\$titleUniqueRule = Rule::unique('posts', 'title');",
            "\$categoryIdExistsRule = Rule::exists('categories', 'id');",
            "\$post = \$this->route('post');",
            "if (\$post) {",
            "    \$titleUniqueRule->ignore(\$post->uuid);",
            "}",
        ]), $printedRules);
    }

    /** @test */
    public function developer_will_not_develop_special_rules_if_there_are_no_unique_or_foreign_key_properties()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('uuid', ModelPropertyType::STRING())
            ->property('title', ModelPropertyType::STRING())
            ->property('body', ModelPropertyType::TEXT());


        $developer = new SpecialRulesDeveloper($this->manager, $this->modelSupervisor);
        $specialRules = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $specialRules);
        $this->assertEmpty($specialRules->getCodes());
    }
}
