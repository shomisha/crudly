<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\ForceDelete;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedForceDeleteTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.force-delete.unauthorized.{$key}";
    }
}
