<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Store;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/**
 * Class StoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\StoreMethodDeveloperManager getManager()
 */
class StoreDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'store';
    }
}
