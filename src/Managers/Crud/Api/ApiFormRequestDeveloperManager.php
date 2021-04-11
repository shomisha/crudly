<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager;

class ApiFormRequestDeveloperManager extends FormRequestDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "api.form-request.{$key}";
    }
}
