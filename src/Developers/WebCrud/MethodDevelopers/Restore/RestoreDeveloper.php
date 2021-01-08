<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Restore;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class RestoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class RestoreDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'restore';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getImplicitBindArgumentDeveloper(),
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getRestoreLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getRestoreAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getRestoreMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getRestoreResponseDeveloper();
    }
}
