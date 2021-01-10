<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Show;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/**
 * Class ShowDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\ShowDeveloperManager getManager()
 */
class ShowDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'show';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getImplicitBindArgumentDeveloper(),
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getShowLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getShowAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getShowMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getShowResponseDeveloper();
    }
}
