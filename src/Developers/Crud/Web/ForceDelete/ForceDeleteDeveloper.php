<?php

namespace Shomisha\Crudly\Developers\Crud\Web\ForceDelete;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class ForceDeleteDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\ForceDeleteMethodDeveloperManager getManager()
 */
class ForceDeleteDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'forceDelete';
    }
}
