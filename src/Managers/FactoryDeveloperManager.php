<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Factory\DefinitionMethodDeveloper;
use Shomisha\Crudly\Developers\Factory\FactoryDefinitionFieldDeveloper;
use Shomisha\Crudly\Developers\Factory\FactoryModelPropertyDeveloper;

class FactoryDeveloperManager extends DeveloperManager
{
    public function getFactoryModelPropertyDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FactoryModelPropertyDeveloper::class, $this);
    }

    public function getDefinitionMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(DefinitionMethodDeveloper::class, $this);
    }

    public function getFactoryDefinitionFieldDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FactoryDefinitionFieldDeveloper::class, $this);
    }
}
