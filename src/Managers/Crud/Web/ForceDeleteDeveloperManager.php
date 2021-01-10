<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeForceDeleteMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\ForceDeleteAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\ForceDelete\ResponseDeveloper as ForceDeleteResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class ForceDeleteDeveloperManager extends CrudDeveloperManager
{
    public function getForceDeleteLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getForceDeleteAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ForceDeleteAuthorizationDeveloper::class, $this);
    }

    public function getForceDeleteMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeForceDeleteMethodDeveloper::class, $this);
    }

    public function getForceDeleteResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ForceDeleteResponseDeveloper::class, $this);
    }
}
