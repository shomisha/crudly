<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class StoreMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.store.{$key}";
    }

    public function getStoreInstantiateDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main.instantiate')
        );
    }

    public function getValidationDeveloper(): Developer
    {
        // TODO: implement a $this->validate validation developer
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main.validate')
        );
    }

    public function getFillDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main.fill')
        );
    }

    public function getSaveDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main.save')
        );
    }
}
