<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class InvalidDataStoreTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.store.invalid.{$key}";
    }
}
