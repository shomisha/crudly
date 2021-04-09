<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class CreateMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.create.{$key}";
    }

    public function getInstantiateDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main.instantiate')
        );
    }

    public function getLoadDependenciesDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main.load-dependencies')
        );
    }
}
