<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\DeleteAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeModelMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnNoContentDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class DestroyMethodDeveloperManager extends CrudMethodDeveloperManager
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
        return $this->instantiateDeveloperWithManager(DeleteAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeModelMethodDeveloper::class, $this)->using(['method' => 'delete']);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ReturnNoContentDeveloper::class, $this);
    }
}
