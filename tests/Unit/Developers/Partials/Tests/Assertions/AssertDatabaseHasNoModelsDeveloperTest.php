<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertDatabaseHasNoModelsDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["Author", "authors"]
     *           ["Wine", "wines"]
     *           ["User", "users"]
     *           ["Book", "books"]
     *           ["Reader", "readers"]
     *           ["Attendee", "attendees"]
     */
    public function developer_can_develop_asserting_database_has_no_models(string $model, string $table)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($model);


        $develop = new AssertDatabaseHasNoModels($this->manager, $this->modelSupervisor);
        $block = $develop->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertDatabaseCount('{$table}', 0);", $block->print());
    }
}
