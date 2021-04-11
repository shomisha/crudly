<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\DeveloperManager;

abstract class TestMethodDeveloperManager extends DeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return $this->instantiateGroupOfDevelopersByKey(
            $this->qualifyConfigKey('arrange')
        );
    }

    public function getActDevelopers(): array
    {
        return $this->instantiateGroupOfDevelopersByKey(
            $this->qualifyConfigKey('act')
        );
    }

    public function getAssertDevelopers(): array
    {
        return $this->instantiateGroupOfDevelopersByKey(
            $this->qualifyConfigKey('assert')
        );
    }

    public function getCreateAndAuthenticateUserDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.authenticate-user');
    }

    public function getAuthorizeUserDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.authorize-user');
    }

    public function getDeauthorizeUserDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.deauthorize-user');
    }

    public function getRefreshModelDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.refresh-model');
    }

    public function getAssertSoftDeletedDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.assert-not-soft-deleted');
    }

    public function getAssertNotSoftDeletedDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.assert-soft-deleted');
    }

    public function getAssertHardDeletedDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.assert-hard-deleted');
    }

    public function getAssertNotHardDeletedDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.assert-not-hard-deleted');
    }

    public function getGetRouteDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('partials.tests.get-route');
    }

    abstract protected function qualifyConfigKey(string $key): string;
}
