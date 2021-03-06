<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseContainsNewModel;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertDatabaseContainsNewModelTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_database_has_new_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Dancer')
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('description', ModelPropertyType::STRING())
            ->property('discipline', ModelPropertyType::STRING());


        $developer = new AssertDatabaseContainsNewModel($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertDatabaseHas('dancers', ['name' => 'New Name', 'email' => 'new@test.com', 'description' => 'New Description']);", $block->print());
    }
}
