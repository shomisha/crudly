<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetEditRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getEditRoute';
    }

    protected function getExceptionMethodName(): string
    {
        return 'provideEditRoute';
    }
}
