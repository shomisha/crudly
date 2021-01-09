<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\Create\AuthorizationDeveloper as CreateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\FormRequestArgumentDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\ResponseDeveloper as StoreResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\ValidateFillAndSaveDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\SaveDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class StoreDeveloperManager extends CrudDeveloperManager
{
    public function getStoreArgumentsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FormRequestArgumentDeveloper::class, $this);
    }

    public function getStoreAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateAuthorizationDeveloper::class, $this);
    }

    public function getStoreMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ValidateFillAndSaveDeveloper::class, $this);
    }

    public function getStoreInstantiateDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->getInstantiateDeveloper();
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
        return $this->instantiateDeveloperWithManager(SaveDeveloper::class, $this);
    }

    public function getStoreResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreResponseDeveloper::class, $this);
    }
}
