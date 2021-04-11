<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedEditTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.edit.unauthorized.{$key}";
    }
}
