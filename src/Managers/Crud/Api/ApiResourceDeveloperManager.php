<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Resource\PropertyResourceMappingDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Resource\ToArrayMethodDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class ApiResourceDeveloperManager extends CrudDeveloperManager
{
    public function getToArrayMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ToArrayMethodDeveloper::class, $this);
    }

    public function getPropertyToResourceMappingDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(PropertyResourceMappingDeveloper::class, $this);
    }
}
