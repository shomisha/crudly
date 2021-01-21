<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetForceDeleteRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getForceDeleteRoute';
    }

    protected function getExceptionMethodName(): string
    {
        return 'provideForceDeleteRoute';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
