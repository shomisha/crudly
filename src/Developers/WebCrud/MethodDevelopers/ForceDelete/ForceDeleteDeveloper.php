<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\ForceDelete;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class ForceDeleteDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\ForceDeleteDeveloperManager getManager()
 */
class ForceDeleteDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'forceDelete';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getImplicitBindArgumentDeveloper(),
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getForceDeleteLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getForceDeleteAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getForceDeleteMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getForceDeleteResponseDeveloper();
    }
}
