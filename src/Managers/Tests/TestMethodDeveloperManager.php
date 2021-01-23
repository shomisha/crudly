<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseForbiddenDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseSuccessfulDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeAuthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeCreateAndAuthenticateUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\InvokeDeauthorizeUserDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Routes\Getters\GetIndexRoute;
use Shomisha\Crudly\Managers\DeveloperManager;

abstract class TestMethodDeveloperManager extends DeveloperManager
{
    abstract public function getArrangeDevelopers(): array;

    abstract public function getActDevelopers(): array;

    abstract public function getAssertDevelopers(): array;

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

    public function getAssertResponseSuccessfulDeveloper(): AssertResponseSuccessfulDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertResponseSuccessfulDeveloper::class, $this);
    }

    public function getAssertResponseForbiddenDeveloper(): AssertResponseForbiddenDeveloper
    {
        return $this->instantiateDeveloperWithManager(AssertResponseForbiddenDeveloper::class, $this);
    }

    public function getIndexRouteDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetIndexRoute::class, $this);
    }
}
