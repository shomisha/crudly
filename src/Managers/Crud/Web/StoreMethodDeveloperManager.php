<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\CreateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\ResponseDeveloper as StoreResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\ValidateFillAndSaveDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation\InvokeSaveMethodDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class StoreMethodDeveloperManager extends CrudMethodDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        // TODO: refactor this to support overriding developers
        return [
            $this->getFormRequestArgumentDeveloper(),
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
        return $this->instantiateDeveloperWithManager(CreateAuthorizationDeveloper::class, $this);
    }

    public function getMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ValidateFillAndSaveDeveloper::class, $this);
    }

    public function getStoreInstantiateDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->getInstantiateDeveloper();
    }

    public function getValidationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        // TODO: implement a $this->validate validation developer
        return $this->nullDeveloper();
    }

    public function getFillDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FillFieldsSeparatelyDeveloper::class, $this);
    }

    public function getSaveDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeSaveMethodDeveloper::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreResponseDeveloper::class, $this);
    }
}
