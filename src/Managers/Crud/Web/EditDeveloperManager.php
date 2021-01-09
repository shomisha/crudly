<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadDependenciesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\UpdateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Edit\ResponseDeveloper as EditResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class EditDeveloperManager extends CrudDeveloperManager
{
    public function getEditLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getEditAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateAuthorizationDeveloper::class, $this);
    }

    public function getEditMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(LoadDependenciesDeveloper::class, $this);
    }

    public function getEditResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(EditResponseDeveloper::class, $this);
    }
}
