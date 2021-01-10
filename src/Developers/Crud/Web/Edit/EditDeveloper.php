<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Edit;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class EditDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\EditMethodDeveloperManager getManager()
 */
class EditDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'edit';
    }
}
