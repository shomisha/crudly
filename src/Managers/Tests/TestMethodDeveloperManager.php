<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasModelDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseMissingModelDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSessionHasSuccessDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNotNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeAuthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeCreateAndAuthenticateUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeDeauthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSingleModelInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\RefreshModelDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetRouteDeveloper;
use Shomisha\Crudly\Managers\DeveloperManager;

abstract class TestMethodDeveloperManager extends DeveloperManager
{
    abstract public function getArrangeDevelopers(): array;

    abstract public function getActDevelopers(): array;

    abstract public function getAssertDevelopers(): array;

    public function getAuthenticateAndAuthorizeUserDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            AuthenticateAndAuthorizeUserDeveloper::class,
            $this
        );
    }

    public function getAuthenticateAndDeauthorizeUserDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            AuthenticateAndDeauthorizeUserDeveloper::class,
            $this
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

    public function getAssertResponseSuccessfulDeveloper(): AssertResponseSuccessfulDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertResponseSuccessfulDeveloper::class, $this);
    }

    public function getAssertResponseForbiddenDeveloper(): AssertResponseForbiddenDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertResponseForbiddenDeveloper::class, $this);
    }

    public function getAssertRedirectToIndexDeveloper(): AssertRedirectToIndexDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertRedirectToIndexDeveloper::class, $this);
    }

    public function getAssertSessionHasSuccessDeveloper(): AssertSessionHasSuccessDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertSessionHasSuccessDeveloper::class, $this);
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

    public function getCreateSingleInstanceDeveloper(): CreateSingleModelInstance
    {
        return $this->instantiateDeveloperWithManager(CreateSingleModelInstance::class, $this);
    }

    public function getGetRouteDeveloper(): GetRouteDeveloper
    {
        return $this->instantiateDeveloperWithManager(GetRouteDeveloper::class, $this);
    }
}
