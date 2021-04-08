<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class IndexMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.controller.index.{$key}";
    }
}
