<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasModelDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseMissingModelDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNotNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeAuthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeCreateAndAuthenticateUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeDeauthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\RefreshModelDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetRouteDeveloper;
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

    public function getCreateAndAuthenticateUserDeveloper(): InvokeCreateAndAuthenticateUserDeveloper
    {
        return $this->instantiateDeveloperWithManager(InvokeCreateAndAuthenticateUserDeveloper::class, $this);
    }

    public function getAuthorizeUserDeveloper(): InvokeAuthorizeUserDeveloper
    {
        return $this->instantiateDeveloperWithManager(InvokeAuthorizeUserDeveloper::class, $this);
    }

    public function getDeauthorizeUserDeveloper(): InvokeDeauthorizeUserDeveloper
    {
        return $this->instantiateDeveloperWithManager(InvokeDeauthorizeUserDeveloper::class, $this);
    }

    public function getRefreshModelDeveloper(): RefreshModelDeveloper
    {
        return $this->instantiateDeveloperWithManager(RefreshModelDeveloper::class, $this);
    }

    public function getAssertSoftDeletedColumnIsNotNullDeveloper(): AssertSoftDeletedColumnIsNotNull
    {
        return $this->instantiateDeveloperWithManager(AssertSoftDeletedColumnIsNotNull::class, $this);
    }

    public function getAssertSoftDeletedColumnIsNullDeveloper(): AssertSoftDeletedColumnIsNull
    {
        return $this->instantiateDeveloperWithManager(AssertSoftDeletedColumnIsNull::class, $this);
    }

    public function getAssertDatabaseMissingModelDeveloper(): AssertDatabaseMissingModelDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertDatabaseMissingModelDeveloper::class, $this);
    }

    public function getAssertDatabaseHasModelDeveloper(): AssertDatabaseHasModelDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertDatabaseHasModelDeveloper::class, $this);
    }

    public function getGetRouteDeveloper(): GetRouteDeveloper
    {
        return $this->instantiateDeveloperWithManager(GetRouteDeveloper::class, $this);
    }

    abstract protected function qualifyConfigKey(string $key): string;
}
