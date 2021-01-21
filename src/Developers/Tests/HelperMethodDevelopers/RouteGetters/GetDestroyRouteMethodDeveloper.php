<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;


class GetDestroyRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getDestroyRoute';
    }

    protected function getExceptionMethodName(): string
    {
        return 'provideDestroyRoute';
    }

    protected function acceptsModelArgument(): bool
    {
        return true;
    }
}
