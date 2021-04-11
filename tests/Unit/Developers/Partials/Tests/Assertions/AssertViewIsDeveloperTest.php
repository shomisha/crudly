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
     * @testWith ["Admin", "index", "admins.index"]
     *           ["Admin", "show", "authenticatable.admins.show", null, "Authenticatables"]
     *           ["Admin", "create", "admins.create", "testResponse"]
     *           ["Admin", "store", "admins.store"]
     *           ["Admin", "edit", "admins.edit", "anotherResponse"]
     *           ["Admin", "update", "admins.update", "requestReturnValue"]
     *           ["Admin", "index", "admins.index"]
     *           ["Author", "index", "blog.authors.index", null, "Blog"]
     */
    public function developer_can_develop_asserting_response_is_specific_view(string $modelName, string $view, string $expectedAssertionView, ?string $responseVar = null, ?string $modelNamespace = null)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName)->namespace($modelNamespace);


        $developer = new AssertViewIsDeveloper($this->manager, $this->modelSupervisor, $view);
        if ($responseVar) {
            $developer->using(['responseVarName' => $responseVar]);
        }
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $expectedResponseVar = $responseVar ?? 'response';
        $this->assertStringContainsString("\${$expectedResponseVar}->assertViewIs('{$expectedAssertionView}');", $block->print());
    }
}
