<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\InvokeDeleteMethodDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Destroy\AuthorizationDeveloper as DestroyAuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Destroy\ResponseDeveloper as DestroyResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class DestroyDeveloperManager extends CrudDeveloperManager
{
    public function getDestroyLoadDeveloper(): Developer
    {
        return $this->nullDeveloper();
    }

    public function getDestroyAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(DestroyAuthorizationDeveloper::class, $this);
    }

    public function getDestroyMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeDeleteMethodDeveloper::class, $this);
    }

    public function getDestroyResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(DestroyResponseDeveloper::class, $this);
    }
}
