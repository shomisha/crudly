<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Show\ResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\ViewAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadRelationshipsDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class ShowDeveloperManager extends CrudDeveloperManager
{
    public function getShowLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getShowAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ViewAuthorizationDeveloper::class, $this);
    }

    public function getShowMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(LoadRelationshipsDeveloper::class, $this);
    }

    public function getShowResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ResponseDeveloper::class, $this);
    }
}
