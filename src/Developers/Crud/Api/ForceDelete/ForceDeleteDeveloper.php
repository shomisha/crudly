<?php

namespace Shomisha\Crudly\Developers\Crud\Api\ForceDelete;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

class ForceDeleteDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'forceDelete';
    }
}
