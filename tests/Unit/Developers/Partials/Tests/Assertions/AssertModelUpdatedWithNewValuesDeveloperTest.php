<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelUpdatedWithNewValuesDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertModelUpdatedWithNewValuesDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_implement_asserting_model_was_updated_with_new_defaults()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('description', ModelPropertyType::STRING());


        $developer = new AssertModelUpdatedWithNewValuesDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$this->assertEquals('New Name', \$author->name);",
            "\$this->assertEquals('new@test.com', \$author->email);",
            "\$this->assertEquals('New Description', \$author->description);",
        ]), $block->print());
    }
}
