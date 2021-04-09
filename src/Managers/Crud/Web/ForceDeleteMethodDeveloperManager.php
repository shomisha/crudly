<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class ForceDeleteMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.force-delete.{$key}";
    }
}
