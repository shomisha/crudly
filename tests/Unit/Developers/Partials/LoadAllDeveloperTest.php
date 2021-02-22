<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Load\LoadAllDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class LoadAllDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_loading_all_models_from_database()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Project');


        $developer = new LoadAllDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);

        $this->assertStringContainsString("\$projects = Project::all();", $block->print());
        $this->assertModelIncludedInCode('Project', $block);
    }
}
