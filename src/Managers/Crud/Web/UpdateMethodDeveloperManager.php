<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeModelMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Update\ResponseDeveloper as UpdateResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Update\ValidateFillAndUpdateDeveloper;
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
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InvokeAuthorizationDeveloper::class, $this)->using(['action' => 'update', 'withModel' => true]);
    }

    public function getMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ValidateFillAndUpdateDeveloper::class, $this);
    }

    public function getValidateDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
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
        return $this->instantiateDeveloperWithManager(InvokeModelMethodDeveloper::class, $this)->using(['method' => 'update']);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateResponseDeveloper::class, $this);
    }
}
