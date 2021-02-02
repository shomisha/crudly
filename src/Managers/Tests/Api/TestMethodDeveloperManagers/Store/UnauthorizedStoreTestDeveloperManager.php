<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedStoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndDeauthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(GetDataWithNewDefaultsDeveloper::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(PostDataToStoreRouteDeveloper::class, $this),
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
