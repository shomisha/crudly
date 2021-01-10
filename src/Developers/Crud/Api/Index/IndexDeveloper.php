<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Index;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/** @method \Shomisha\Crudly\Managers\Crud\Api\IndexDeveloperManager getManager() */
class IndexDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'index';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getIndexLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getIndexAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getIndexMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getIndexResponseDeveloper();
    }
}
