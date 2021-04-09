<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Show;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedShowTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.show.unauthorized.{$key}";
    }
}
