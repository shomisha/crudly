<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Update;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/**
 * Class UpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\UpdateDeveloperManager getManager()
 */
class UpdateDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'update';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getFormRequestArgumentDeveloper(),
            $this->getManager()->getImplicitBindArgumentDeveloper(),
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getUpdateLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getUpdateAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getUpdateMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getUpdateResponseDeveloper();
    }
}
