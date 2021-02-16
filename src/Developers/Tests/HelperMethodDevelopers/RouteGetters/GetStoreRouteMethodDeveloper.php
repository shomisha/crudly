<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;


class GetStoreRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'store';
    }

    protected function getRouteName(): string
    {
        return 'store';
    }
}
