<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeRestoreMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\RestoreAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Restore\ResponseDeveloper as RestoreResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class RestoreMethodDeveloperManager extends CrudMethodDeveloperManager
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
        return $this->instantiateDeveloperWithManager(RestoreAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeRestoreMethodDeveloper::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreResponseDeveloper::class, $this);
    }
}
