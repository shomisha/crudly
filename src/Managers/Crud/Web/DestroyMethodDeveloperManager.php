<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeModelMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Destroy\ResponseDeveloper as DestroyResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class DestroyMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.destroy.{$key}";
    }
}
