<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Authentication;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeCreateAndAuthenticateUserDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class InvokeCreateAndAuthenticateUserDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_create_and_authenticate_method_invocation_and_assigning()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Planet');


        $developer = new InvokeCreateAndAuthenticateUserDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$user = \$this->createAndAuthenticateUser();", $block->print());
    }
}
