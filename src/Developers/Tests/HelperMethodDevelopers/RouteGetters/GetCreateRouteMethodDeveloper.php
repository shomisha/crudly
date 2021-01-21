<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

class GetCreateRouteMethodDeveloper extends RouteGetterDeveloper
{
    protected function getName(): string
    {
        return 'getCreateRoute';
    }

    protected function getExceptionMethodName(): string
    {
        return 'provideCreateRoute';
    }
}
