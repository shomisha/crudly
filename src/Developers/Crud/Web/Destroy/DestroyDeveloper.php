<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Destroy;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class Destroy
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\DestroyMethodDeveloperManager getManager()
 */
class DestroyDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'destroy';
    }
}
