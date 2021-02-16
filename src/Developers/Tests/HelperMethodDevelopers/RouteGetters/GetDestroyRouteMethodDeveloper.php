<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;


class GetDestroyRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getDestroyRoute';
    }

    protected function getRouteName(): string
    {
        return 'destroy';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
