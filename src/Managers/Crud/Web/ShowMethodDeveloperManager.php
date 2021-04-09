<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class ShowMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.show.{$key}";
    }
}
