<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseContainsNewModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\SendStoreDataRequest;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class StoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(GetDataWithNewDefaultsDeveloper::class, $this),
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
            $this->getAssertRedirectToIndexDeveloper(),
            $this->getAssertSessionHasSuccessDeveloper(),
            $this->instantiateDeveloperWithManager(AssertDatabaseContainsNewModel::class, $this),
        ];
    }
}
