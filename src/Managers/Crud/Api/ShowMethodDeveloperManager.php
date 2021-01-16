<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\ViewAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadRelationshipsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnSingleResourceDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class ShowMethodDeveloperManager extends CrudMethodDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        // TODO: refactor this to support overriding developers
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
        return $this->instantiateDeveloperWithManager(ViewAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(LoadRelationshipsDeveloper::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ReturnSingleResourceDeveloper::class, $this);
    }
}