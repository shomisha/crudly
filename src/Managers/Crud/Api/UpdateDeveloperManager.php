<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Update\ValidateFillAndUpdateDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\UpdateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeUpdateMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnSingleResourceDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class UpdateDeveloperManager extends CrudDeveloperManager
{
    public function getUpdateLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getUpdateAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(UpdateAuthorizationDeveloper::class, $this);
    }

    public function getUpdateMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ValidateFillAndUpdateDeveloper::class, $this);
    }

    public function getUpdateValidateDeveloper(): Developer
    {
        return $this->nullDeveloper();
    }

    public function getUpdateFillDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(FillFieldsSeparatelyDeveloper::class, $this);
    }

    public function getUpdateSaveDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeUpdateMethodDeveloper::class, $this);
    }

    public function getUpdateResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ReturnSingleResourceDeveloper::class , $this);
    }
}
