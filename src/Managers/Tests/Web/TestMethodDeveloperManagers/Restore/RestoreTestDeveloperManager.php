<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class RestoreTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.restore.{$key}";
    }
}
