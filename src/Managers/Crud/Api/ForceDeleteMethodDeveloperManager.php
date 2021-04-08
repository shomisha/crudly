<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class ForceDeleteMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.controller.force-delete.{$key}";
    }
}
