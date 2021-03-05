<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertSessionHasSuccessDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_session_has_success()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new AssertSessionHasSuccessDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$response->assertSessionHas('success');", $block->print());
    }
}
