<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class IndexMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.index.{$key}";
    }
}
