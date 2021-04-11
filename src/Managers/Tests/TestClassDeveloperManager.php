<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers as TestHelpers;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class TestClassDeveloperManager extends BaseDeveloperManager
{
    abstract public function getRouteMethodDevelopers(): array;

    public function getModelDataSpecialDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\GetModelDataSpecialDefaultsDeveloper::class, $this);
    }

    public function getModelDataPrimeDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\GetModelDataPrimeDefaultsDeveloper::class, $this);
    }
}
