<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedStoreTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.store.unauthorized.{$key}";
    }
}
