<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\ForceDeleteAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeForceDeleteMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnNoContentDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class ForceDeleteMethodDeveloperManager extends CrudMethodDeveloperManager
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
        return $this->instantiateDeveloperWithManager(ForceDeleteAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeForceDeleteMethodDeveloper::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ReturnNoContentDeveloper::class, $this);
    }
}
