<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeAuthorizationDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class InvokeAuthorizationDeveloperTest extends DeveloperTestCase
{
    public function authorizationActionsDataProvider()
    {
        return [
            "Index" => ["viewAll", "Post", false, true],
            "Show" => ["view", "Author", true, false],
            "Create" => ["create", "Product", false, true],
            "Update" => ["update", "Website", true, false],
            "Delete" => ["delete", "Training", true, false],
            "Force delete" => ["forceDelete", "Listing", true, false],
            "Restore" => ["restore", "User", true, false],
        ];
    }

    /**
     * @test
     * @dataProvider authorizationActionsDataProvider
     */
    public function developer_will_develop_invoke_authorization_block(string $action, string $modelName, bool $withModel = false, bool $withClass = false)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName);


        $developer = new InvokeAuthorizationDeveloper($this->manager, $this->modelSupervisor, $action, $withClass, $withModel);


        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $authorizationArgument = ($withModel) ? ('$' . strtolower($modelName)) : "{$modelName}::class";
        $expectedBlock = "\$this->authorize('{$action}', {$authorizationArgument});";
        $this->assertStringContainsString($expectedBlock, $block->print());

        if ($withClass) {
            $this->assertModelIncludedInCode($modelName, $block);
        }
    }
}
