<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSessionHasFieldErrorDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertSessionHasFieldErrorDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_that_session_has_field_error()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new AssertSessionHasFieldErrorDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$response->assertSessionHasErrors(\$field);", $block->print());
    }
}
