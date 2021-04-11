<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.index.{$key}";
    }
}
