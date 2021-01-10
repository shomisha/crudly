<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Store\InstantiateFillAndSaveDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\CreateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InstantiateDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeSaveMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnSingleResourceDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class StoreDeveloperManager extends CrudDeveloperManager
{
    public function getStoreLoadDeveloper(): Developer
    {
        return $this->nullDeveloper();
    }

    public function getStoreAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(CreateAuthorizationDeveloper::class, $this);
    }

    public function getStoreMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InstantiateFillAndSaveDeveloper::class, $this);
    }

    public function getStoreInstantiateDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InstantiateDeveloper::class, $this);
    }

    public function getStoreValidationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        // TODO: implement a $this->validate validation developer
        return $this->nullDeveloper();
    }

    public function getStoreFillDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FillFieldsSeparatelyDeveloper::class, $this);
    }

    public function getStoreSaveDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeSaveMethodDeveloper::class, $this);
    }

    public function getStoreResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ReturnSingleResourceDeveloper::class, $this);
    }
}
