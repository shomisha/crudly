<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedDestroyTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.destroy.unauthorized.{$key}";
    }
}
