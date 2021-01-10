<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class StoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\StoreMethodDeveloperManager getManager()
 */
class StoreDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'store';
    }
}
