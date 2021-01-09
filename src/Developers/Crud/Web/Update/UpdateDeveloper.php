<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Update;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class UpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\UpdateDeveloperManager getManager()
 */
class UpdateDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'update';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getImplicitBindArgumentDeveloper(),
            $this->getManager()->getFormRequestArgumentDeveloper(),
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