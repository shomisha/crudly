<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class EditMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.edit.{$key}";
    }
}
