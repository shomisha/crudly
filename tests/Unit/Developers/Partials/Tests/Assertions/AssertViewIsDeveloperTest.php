<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertViewIsDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["index", "admins.index"]
     *           ["show", "admins.show"]
     *           ["create", "admins.create", "testResponse"]
     *           ["store", "admins.store"]
     *           ["edit", "admins.edit", "anotherResponse"]
     *           ["update", "admins.update", "requestReturnValue"]
     *           ["index", "admins.index"]
     */
    public function developer_can_develop_asserting_response_is_specific_view(string $view, string $expectedAssertionView, ?string $responseVar = null)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Admin');

        $parameters = ['view' => $view];
        if ($responseVar) {
            $parameters['responseVarName'] = $responseVar;
        }

        $developer = new AssertViewIsDeveloper($this->manager, $this->modelSupervisor);
        $developer->using($parameters);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $expectedResponseVar = $responseVar ?? 'response';
        $this->assertStringContainsString("\${$expectedResponseVar}->assertViewIs('{$expectedAssertionView}');", $block->print());
    }
}
