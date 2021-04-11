<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIsTestModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSingleModelInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadEditPageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class EditTestDeveloperManager extends TestMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.tests.edit.{$key}";
    }
}
