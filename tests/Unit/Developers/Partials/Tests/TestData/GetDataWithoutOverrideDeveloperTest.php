<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\TestData;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithoutOverrideDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class GetDataWithoutOverrideDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_getting_request_data()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new GetDataWithoutOverrideDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$data = \$this->getPostData();", $block->print());
    }
}
