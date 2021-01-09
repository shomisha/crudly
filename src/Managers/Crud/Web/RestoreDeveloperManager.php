<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\InvokeRestoreMethodDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Restore\AuthorizationDeveloper as RestoreAuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Restore\ResponseDeveloper as RestoreResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class RestoreDeveloperManager extends CrudDeveloperManager
{
    public function getRestoreLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getRestoreAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreAuthorizationDeveloper::class, $this);
    }

    public function getRestoreMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeRestoreMethodDeveloper::class, $this);
    }

    public function getRestoreResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreResponseDeveloper::class, $this);
    }
}
