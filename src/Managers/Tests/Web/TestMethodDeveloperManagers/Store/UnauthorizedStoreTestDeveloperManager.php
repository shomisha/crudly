<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\SendStoreDataRequest;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithoutOverrideDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedStoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getDeauthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(GetDataWithoutOverrideDeveloper::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(SendStoreDataRequest::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseForbiddenDeveloper(),
            $this->instantiateDeveloperWithManager(AssertDatabaseHasNoModels::class, $this),
        ];
    }
}
