<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Update;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class UpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\UpdateMethodDeveloperManager getManager()
 */
class UpdateDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'update';
    }
}
