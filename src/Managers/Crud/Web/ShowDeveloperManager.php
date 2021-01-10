<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\ViewAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadRelationshipsDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Show\ResponseDeveloper as ShowResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class ShowDeveloperManager extends CrudDeveloperManager
{
    public function getShowArgumentsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->getImplicitBindArgumentDeveloper();
    }

    public function getShowLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getShowAuthorizationDeveloper(): Developer
    {
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
        return $this->instantiateDeveloperWithManager(ShowResponseDeveloper::class, $this);
    }
}
