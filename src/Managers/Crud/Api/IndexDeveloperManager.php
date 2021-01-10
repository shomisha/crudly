<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Index\ResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization\ViewAllAuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Load\PaginateDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class IndexDeveloperManager extends CrudDeveloperManager
{
    public function getIndexLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getIndexAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ViewAllAuthorizationDeveloper::class, $this);
    }

    public function getIndexMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(PaginateDeveloper::class, $this);
    }

    public function getIndexResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ResponseDeveloper::class, $this);
    }
}
