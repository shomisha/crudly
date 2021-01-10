<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InstantiateDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadDependenciesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ImplicitBindArgumentsDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\FormRequestArgumentDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class CrudMethodDeveloperManager extends BaseDeveloperManager
{
    abstract public function getArgumentsDeveloper(): array ;

    abstract public function getLoadDeveloper(): Developer;

    abstract public function getAuthorizationDeveloper(): Developer;

    abstract public function getMainDeveloper(): Developer;

    abstract public function getResponseDeveloper(): Developer;


    public function getImplicitBindArgumentDeveloper(): ImplicitBindArgumentsDeveloper
    {
        return $this->instantiateDeveloperWithManager(ImplicitBindArgumentsDeveloper::class, $this);
    }

    public function getFormRequestArgumentDeveloper(): FormRequestArgumentDeveloper
    {
        return $this->instantiateDeveloperWithManager(FormRequestArgumentDeveloper::class, $this);
    }

    public function getInstantiateDeveloper(): InstantiateDeveloper
    {
        return $this->instantiateDeveloperWithManager(InstantiateDeveloper::class, $this);
    }

    public function getLoadDependenciesDeveloper(): LoadDependenciesDeveloper
    {
        return $this->instantiateDeveloperWithManager(LoadDependenciesDeveloper::class, $this);
    }
}
