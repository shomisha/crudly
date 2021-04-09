<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\ForceDelete;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class ForceDeleteTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.force-delete.{$key}";
    }
}
