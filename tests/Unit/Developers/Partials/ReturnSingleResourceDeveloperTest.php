<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnSingleResourceDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class ReturnSingleResourceDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_returning_single_model_resource()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Resident');


        $developer = new ReturnSingleResourceDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ReturnBlock::class, $block);

        $printedBlock = $block->print();
        $this->assertStringContainsString("use App\Http\Resources\ResidentResource;", $printedBlock);
        $this->assertStringContainsString("return new ResidentResource(\$resident);", $printedBlock);
    }
}
