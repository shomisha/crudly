<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class RestoreMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.restore.{$key}";
    }
}
