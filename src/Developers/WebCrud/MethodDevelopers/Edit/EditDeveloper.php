<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Edit;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class EditDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class EditDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'edit';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getImplicitBindArgumentDeveloper()
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getEditLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getEditAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getEditMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getEditResponseDeveloper();
    }
}
