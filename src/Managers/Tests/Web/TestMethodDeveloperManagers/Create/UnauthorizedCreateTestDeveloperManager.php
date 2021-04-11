<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedCreateTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.create.unauthorized.{$key}";
    }
}
