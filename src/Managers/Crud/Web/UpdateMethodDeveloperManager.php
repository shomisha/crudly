<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager;

class UpdateMethodDeveloperManager extends CrudMethodDeveloperManager
{
    protected function qualifyConfigKey(string $key): string
    {
        return "web.controller.update.{$key}";
    }

    public function getValidateDeveloper(): Developer
    {
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
            $this->qualifyConfigKey("main.update")
        );
    }
}
