<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetIndexRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getIndexRoute';
    }

    protected function getRouteName(): string
    {
        return 'index';
    }
}
