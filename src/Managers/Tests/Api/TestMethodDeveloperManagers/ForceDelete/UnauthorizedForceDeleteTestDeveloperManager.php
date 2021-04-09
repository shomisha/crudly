<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\ForceDelete;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedForceDeleteTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.tests.force-delete.unauthorized.{$key}";
    }
}
