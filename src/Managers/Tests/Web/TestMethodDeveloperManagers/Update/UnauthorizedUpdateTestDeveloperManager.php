<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Update;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedUpdateTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.update.unauthorized.{$key}";
    }
}
