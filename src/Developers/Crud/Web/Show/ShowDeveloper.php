<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Show;

use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class ShowDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\ShowMethodDeveloperManager getManager()
 */
class ShowDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'show';
    }
}
