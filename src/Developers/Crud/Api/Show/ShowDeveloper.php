<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Show;

use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/**
 * Class ShowDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\ShowMethodDeveloperManager getManager()
 */
class ShowDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'show';
    }
}
