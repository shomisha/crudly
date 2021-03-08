<?php

namespace Shomisha\Crudly\Developers\Crud\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetCreateRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetDestroyRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetEditRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetForceDeleteRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetIndexRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetRestoreRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetShowRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetStoreRouteMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters\GetUpdateRouteMethodDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;

class RouteGetterDevelopersTest extends DeveloperTestCase
{
    public function routeGetterDataProvider()
    {
        return [
            "Index" => [
                GetIndexRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getIndexRoute() : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('index');",
                    "}",
                ]),
            ],
            "Show" => [
                GetShowRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getShowRoute(Post \$post) : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('show');",
                    "}",
                ]),
            ],
            "Create" => [
                GetCreateRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getCreateRoute() : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('create');",
                    "}",
                ]),
            ],
            "Store" => [
                GetStoreRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getStoreRoute() : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('store');",
                    "}",
                ]),
            ],
            "Edit" => [
                GetEditRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getEditRoute(Post \$post) : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('edit');",
                    "}",
                ]),
            ],
            "Update" => [
                GetUpdateRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getUpdateRoute(Post \$post) : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('update');",
                    "}",
                ]),
            ],
            "Destroy" => [
                GetDestroyRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getDestroyRoute(Post \$post) : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('destroy');",
                    "}",
                ]),
            ],
            "Force delete" => [
                GetForceDeleteRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getForceDeleteRoute(Post \$post) : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('force-delete');",
                    "}",
                ]),
            ],
            "Restore" => [
                GetRestoreRouteMethodDeveloper::class,
                implode("\n", [
                    "private function getRestoreRoute(Post \$post) : string",
                    "{",
                    "    throw IncompleteTestException::missingRouteGetter('restore');",
                    "}",
                ]),
            ],
        ];
    }

    /**
     * @test
     * @dataProvider routeGetterDataProvider
     */
    public function developers_will_develop_route_fetching(string $developer, string $expectedRouteFetching)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new $developer($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $block);
        $this->assertStringContainsString($expectedRouteFetching, $block->print());
    }
}
