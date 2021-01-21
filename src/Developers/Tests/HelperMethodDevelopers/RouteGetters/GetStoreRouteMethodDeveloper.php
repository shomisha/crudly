<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;


class GetStoreRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getStoreRoute';
    }

    protected function getExceptionMethodName(): string
    {
        return 'provideStoreRoute';
    }
}
