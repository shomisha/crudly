<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class ApiResourceDeveloperManager extends BaseDeveloperManager
{
    public function getToArrayMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.resource.to-array-method'
        );
    }

    public function getPropertyToResourceMappingDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.resource.property-resource-mapping'
        );
    }
}
