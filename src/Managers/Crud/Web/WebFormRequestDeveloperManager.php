<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager;

class WebFormRequestDeveloperManager extends FormRequestDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.form-request.{$key}";
    }
}
