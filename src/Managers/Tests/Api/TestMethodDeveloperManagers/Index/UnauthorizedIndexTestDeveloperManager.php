<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedIndexTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.index.unauthorized.{$key}";
    }
}
