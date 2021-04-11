<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexWillNotContainSoftDeletedModelsTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.index.missing-soft-deleted.{$key}";
    }
}
