<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Destroy;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class Destroy
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class DestroyDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'destroy';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getImplicitBindArgumentDeveloper(),
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getDestroyLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getDestroyAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getDestroyMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getDestroyResponseDeveloper();
    }
}
