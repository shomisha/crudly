<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertResponseStatusDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith [200]
     *           [201]
     *           [422]
     *           [400, "responseVar"]
     *           [500, "request"]
     *           [204, "requestReturnValue"]
     */
    public function developer_can_develop_asserting_response_status(int $expectedStatus, ?string $responseVar = null)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $parameters = ['status' => $expectedStatus];
        if ($responseVar) {
            $parameters['responseVarName'] = $responseVar;
        }


        $developer = new AssertResponseStatusDeveloper($this->manager, $this->modelSupervisor);
        $developer->using($parameters);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $expectedResponseVar = $responseVar ?? 'response';
        $this->assertStringContainsString("\${$expectedResponseVar}->assertStatus({$expectedStatus});", $block->print());
    }
}
