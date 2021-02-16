<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;


class GetUpdateRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getUpdateRoute';
    }

    protected function getRouteName(): string
    {
        return 'update';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
