<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeUpdateMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Edit\AuthorizationDeveloper as UpdateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Update\ResponseDeveloper as UpdateResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Update\ValidateFillAndUpdateDeveloper;
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
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateAuthorizationDeveloper::class, $this);
    }

    public function getUpdateMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ValidateFillAndUpdateDeveloper::class, $this);
    }

    public function getUpdateValidateDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getUpdateFillDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FillFieldsSeparatelyDeveloper::class, $this);
    }

    public function getUpdateSaveDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeUpdateMethodDeveloper::class, $this);
    }

    public function getUpdateResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateResponseDeveloper::class, $this);
    }
}
