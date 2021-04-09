<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Restore;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class RestoreTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.restore.{$key}";
    }
}
