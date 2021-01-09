<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\Index\AuthorizationDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Index\Main\PaginateDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Index\ResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class IndexDeveloperManager extends CrudDeveloperManager
{
    public function getIndexAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(AuthorizationDeveloper::class, $this);
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
