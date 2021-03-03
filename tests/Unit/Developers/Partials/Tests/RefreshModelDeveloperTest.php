<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\RefreshModelDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class RefreshModelDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["Post", "post"]
     *           ["Author", "author"]
     *           ["Article", "article"]
     *           ["Vehicle", "vehicle"]
     *           ["Book", "book"]
     */
    public function developer_can_develop_model_refresh_method_invocation(string $modelName, string $modelVar)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName);


        $developer = new RefreshModelDeveloper($this->manager, $this->modelSupervisor);
        $invocation = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $invocation);
        $this->assertStringContainsString(
            "\${$modelVar}->refresh();",
            $invocation->print()
        );
    }
}
