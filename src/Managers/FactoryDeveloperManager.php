<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;

class FactoryDeveloperManager extends DeveloperManager
{
    public function getFactoryModelPropertyDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('factory.model-property');
    }

    public function getDefinitionMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('factory.definition-method');
    }

    public function getFactoryDefinitionFieldDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('factory.definition-fields');
    }
}
