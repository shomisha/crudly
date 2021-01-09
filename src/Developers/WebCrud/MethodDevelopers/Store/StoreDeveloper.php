<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class StoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\StoreDeveloperManager getManager()
 */
class StoreDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'store';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getFormRequestArgumentDeveloper()
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->nullDeveloper();
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
