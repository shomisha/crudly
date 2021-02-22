<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnNoContentDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class ReturnNoContentDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_returning_no_content()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new ReturnNoContentDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ReturnBlock::class, $block);

        $this->assertStringContainsString("return response()->noContent();", $block->print());
    }
}
