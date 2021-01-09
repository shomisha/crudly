<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Create;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\WebCrudMethodDeveloper;

/**
 * Class CreateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\CreateDeveloperManager getManager()
 */
class CreateDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'create';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getCreateLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getCreateAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getCreateMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getCreateResponseDeveloper();
    }
}
