<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeDeleteMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\DeleteAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Destroy\ResponseDeveloper as DestroyResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class DestroyDeveloperManager extends CrudDeveloperManager
{
    public function getDestroyLoadDeveloper(): Developer
    {
        return $this->nullDeveloper();
    }

    public function getDestroyAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(DeleteAuthorizationDeveloper::class, $this);
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
