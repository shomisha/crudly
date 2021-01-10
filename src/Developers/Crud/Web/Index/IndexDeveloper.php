<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Index;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class IndexDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\IndexMethodDeveloperManager getManager()
 */
class IndexDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'index';
    }
}
