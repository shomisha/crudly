<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\CreateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Create\InstantiatePlaceholderAndLoadDependencies;
use Shomisha\Crudly\Developers\Crud\Web\Create\ResponseDeveloper as CreateResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class CreateMethodDeveloperManager extends CrudMethodDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        return [

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
        return $this->instantiateDeveloperWithManager(InstantiatePlaceholderAndLoadDependencies::class, $this);
    }

    public function getResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateResponseDeveloper::class, $this);
    }
}
