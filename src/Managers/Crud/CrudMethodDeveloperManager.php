<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldUsingRequestInputDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class CrudMethodDeveloperManager extends BaseDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        return $this->instantiateGroupOfDevelopersByKey(
            $this->qualifyConfigKey('arguments')
        );
    }

    public function getLoadDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('load')
        );
    }

    public function getAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('authorization')
        );
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main')
        );
    }

    public function getResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('response')
        );
    }

    public function getFillFieldDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.crud.fill-field');
    }

    abstract protected function qualifyConfigKey(string $key): string;
}
