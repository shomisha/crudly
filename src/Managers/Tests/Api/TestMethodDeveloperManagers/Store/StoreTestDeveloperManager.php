<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseContainsNewModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusCreatedDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class StoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
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
            $this->instantiateDeveloperWithManager(AssertResponseStatusCreatedDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertDatabaseContainsNewModel::class, $this),
        ];
    }
}
