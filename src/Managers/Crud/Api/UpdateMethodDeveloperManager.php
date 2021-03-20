<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Update\ValidateFillAndUpdateDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeModelMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnNoContentDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ReturnSingleResourceDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class UpdateMethodDeveloperManager extends CrudMethodDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        return [
            $this->getFormRequestArgumentDeveloper(),
            $this->getImplicitBindArgumentDeveloper(),
        ];
    }

    public function getLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeAuthorizationDeveloper::class, $this)->using(['action' => 'update', 'withModel' => true]);
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ValidateFillAndUpdateDeveloper::class, $this);
    }

    public function getValidateDeveloper(): Developer
    {
        return $this->nullDeveloper();
    }

    public function getFillDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(FillFieldsSeparatelyDeveloper::class, $this);
    }

    public function getSaveDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(InvokeModelMethodDeveloper::class, $this)->using(['method' => 'update']);
    }

    public function getResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ReturnNoContentDeveloper::class , $this);
    }
}
