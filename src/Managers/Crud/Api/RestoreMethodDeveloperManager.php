<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\RestoreAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeRestoreMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnNoContentDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class RestoreMethodDeveloperManager extends CrudMethodDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        return [
            $this->getImplicitBindArgumentDeveloper(),
        ];
    }

    public function getLoadDeveloper(): Developer
    {
        return $this->nullDeveloper();
    }

    public function getAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(RestoreAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeRestoreMethodDeveloper::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ReturnNoContentDeveloper::class, $this);
    }
}
