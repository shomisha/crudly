<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Destroy;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

class DestroyDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'destroy';
    }
}
