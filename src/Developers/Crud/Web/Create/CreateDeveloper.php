<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Create;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class CreateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\CreateMethodDeveloperManager getManager()
 */
class CreateDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'create';
    }
}
