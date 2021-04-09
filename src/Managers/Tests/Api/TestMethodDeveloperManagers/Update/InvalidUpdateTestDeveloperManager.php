<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Update;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class InvalidUpdateTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.update.invalid.{$key}";
    }
}
