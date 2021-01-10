<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class CrudMethodDeveloperManager extends CrudDeveloperManager
{
    abstract public function getArgumentsDeveloper(): array ;

    abstract public function getLoadDeveloper(): Developer;

    abstract public function getAuthorizationDeveloper(): Developer;

    abstract public function getMainDeveloper(): Developer;

    abstract public function getResponseDeveloper(): Developer;
}
