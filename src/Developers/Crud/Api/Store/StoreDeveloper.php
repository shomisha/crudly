<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Store;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\ApiCrudMethodDeveloper;

/**
 * Class StoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\StoreDeveloperManager getManager()
 */
class StoreDeveloper extends ApiCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'store';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getFormRequestArgumentDeveloper(),
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getStoreLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getStoreAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getStoreMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getStoreResponseDeveloper();
    }
}
