<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Index;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/** @method \Shomisha\Crudly\Managers\Crud\Api\IndexMethodDeveloperManager getManager() */
class IndexDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'index';
    }
}
