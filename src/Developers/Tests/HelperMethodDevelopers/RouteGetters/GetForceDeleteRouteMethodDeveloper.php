<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetForceDeleteRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getForceDeleteRoute';
    }

    protected function getRouteName(): string
    {
        return 'force-delete';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
