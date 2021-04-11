<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Destroy;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class DestroyTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.destroy.{$key}";
    }
}
