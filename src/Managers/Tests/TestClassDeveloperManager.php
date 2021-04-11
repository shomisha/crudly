<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class TestClassDeveloperManager extends BaseDeveloperManager
{
    abstract public function getRouteMethodDevelopers(): array;

    abstract protected function qualifyConfigKey(string $key): string;

    public function getModelDataSpecialDefaultsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('helpers.get-data.special')
        );
    }

    public function getModelDataPrimeDefaultsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('helpers.get-data.prime')
        );
    }
}
