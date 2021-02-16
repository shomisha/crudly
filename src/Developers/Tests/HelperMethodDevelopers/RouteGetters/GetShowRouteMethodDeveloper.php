<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetShowRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getShowRoute';
    }

    protected function getRouteName(): string
    {
        return 'show';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
