<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Show;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedShowTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.show.unauthorized.{$key}";
    }
}
