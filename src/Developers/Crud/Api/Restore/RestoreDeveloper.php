<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Restore;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

class RestoreDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'restore';
    }
}
