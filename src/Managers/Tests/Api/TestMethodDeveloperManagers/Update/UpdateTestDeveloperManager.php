<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Update;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UpdateTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.update.{$key}";
    }
}
