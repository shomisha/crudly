<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedRestoreTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.restore.unauthorized.{$key}";
    }
}
