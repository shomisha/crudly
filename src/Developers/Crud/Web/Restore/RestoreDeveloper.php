<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Restore;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class RestoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\RestoreMethodDeveloperManager getManager()
 */
class RestoreDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'restore';
    }
}
