<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadDependenciesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\UpdateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Edit\ResponseDeveloper as EditResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class EditMethodDeveloperManager extends CrudMethodDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        return [
            $this->getImplicitBindArgumentDeveloper(),
        ];
    }

    public function getLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(LoadDependenciesDeveloper::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(EditResponseDeveloper::class, $this);
    }
}
