<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetRestoreRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getRestoreRoute';
    }

    protected function getExceptionMethodName(): string
    {
        return 'provideRestoreRoute';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
