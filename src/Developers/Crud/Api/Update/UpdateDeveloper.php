<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Update;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/**
 * Class UpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\UpdateMethodDeveloperManager getManager()
 */
class UpdateDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'update';
    }
}
