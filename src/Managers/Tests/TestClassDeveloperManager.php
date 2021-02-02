<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers as TestHelpers;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class TestClassDeveloperManager extends BaseDeveloperManager
{
    abstract public function getRouteMethodDevelopers(): array;

    public function getAuthenticateUserMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\AuthenticateUserMethodDeveloper::class, $this);
    }

    public function getAuthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\AuthorizeUserMethodDeveloper::class, $this);
    }

    public function getDeauthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\DeauthorizeUserMethodDeveloper::class, $this);
    }

    public function getDataMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\GetModelDataMethodDeveloper::class, $this);
    }

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
