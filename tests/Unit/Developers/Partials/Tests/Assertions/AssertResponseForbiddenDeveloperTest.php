<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertResponseForbiddenDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_response_is_forbidden()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new AssertResponseForbiddenDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$response->assertForbidden();", $block->print());
    }
}
