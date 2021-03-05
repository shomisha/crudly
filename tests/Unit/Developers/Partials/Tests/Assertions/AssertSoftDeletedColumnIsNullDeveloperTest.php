<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertSoftDeletedColumnIsNullDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["Article", "article", "archived_at"]
     *           ["Player", "player", "banned_at"]
     *           ["Purchase", "purchase", "refunded_at"]
     *           ["Ship", "ship", "abandoned_at"]
     */
    public function developer_can_develop_asserting_that_deleted_at_column_is_null(string $modelName, string $modelVar, string $deletedAtColumn)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName)
            ->softDeletes(true)
            ->softDeletionColumn($deletedAtColumn);


        $developer = new AssertSoftDeletedColumnIsNull($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertNull(\${$modelVar}->{$deletedAtColumn});", $block->print());
    }
}
