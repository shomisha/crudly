<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetRouteDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class GetRouteDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["index", false, "getIndexRoute()"]
     *           ["create", false, "getCreateRoute()"]
     *           ["show", true, "getShowRoute($post)"]
     *           ["update", true, "getUpdateRoute($post)"]
     */
    public function developer_can_develop_route_getter_invocation(string $routeName, bool $withModel, string $printedInvocation)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new GetRouteDeveloper($this->manager, $this->modelSupervisor);
        $developer->using([
            'route' => $routeName,
            'withModel' => $withModel,
        ]);
        $invocation = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $invocation);

        $this->assertStringContainsString(
            "\$this->{$printedInvocation};",
            $invocation->print()
        );
    }

    /** @test */
    public function developer_will_assume_model_argument_is_not_needed()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $developer = new GetRouteDeveloper($this->manager, $this->modelSupervisor);
        $developer->using([
            'route' => 'index',
        ]);
        $printedInvocation = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$this->getIndexRoute();", $printedInvocation);
    }
}
