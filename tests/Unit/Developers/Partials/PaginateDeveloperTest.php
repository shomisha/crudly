<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Load\PaginateDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class PaginateDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_paginating_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Task');


        $developer = new PaginateDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);

        $this->assertStringContainsString("\$tasks = Task::paginate();", $block->print());
        $this->assertModelIncludedInCode('Task', $block);
    }
}
