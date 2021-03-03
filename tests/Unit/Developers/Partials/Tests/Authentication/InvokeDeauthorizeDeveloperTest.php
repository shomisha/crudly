<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Authentication;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeDeauthorizeUserDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class InvokeDeauthorizeDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_deauthorize_method_invocation()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Discount');


        $developer = new InvokeDeauthorizeUserDeveloper($this->manager, $this->modelSupervisor);
        $invocation = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $invocation);
        $this->assertStringContainsString("\$this->deauthorizeUser(\$user);", $invocation->print());
    }
}
