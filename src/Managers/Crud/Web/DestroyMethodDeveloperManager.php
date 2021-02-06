<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\DeleteAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeModelMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Destroy\ResponseDeveloper as DestroyResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class DestroyMethodDeveloperManager extends CrudMethodDeveloperManager
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
        return $this->instantiateDeveloperWithManager(DeleteAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeModelMethodDeveloper::class, $this)->using(['method' => 'delete']);

    }

    public function getResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(DestroyResponseDeveloper::class, $this);
    }
}
