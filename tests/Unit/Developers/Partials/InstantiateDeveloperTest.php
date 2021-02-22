<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InstantiateDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;


class InstantiateDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["Post", "post"]
     *           ["Author", "author"]
     *           ["Car", "car"]
     *           ["Idea", "idea"]
     *           ["Criterium", "criterium"]
     */
    public function developer_will_develop_instantiation_block(string $modelName, string $expectedVariableName)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName);


        $developer = new InstantiateDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\${$expectedVariableName} = new {$modelName}();", $block->print());

        $this->assertModelIncludedInCode($modelName, $block);
    }
}
