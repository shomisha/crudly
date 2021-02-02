<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasNoModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusValidationErrorDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSessionHasFieldErrorDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithInvalidOverrideDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class InvalidStoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(GetDataWithInvalidOverrideDeveloper::class, $this),
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
            $this->instantiateDeveloperWithManager(AssertResponseStatusValidationErrorDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertSessionHasFieldErrorDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertDatabaseHasNoModels::class, $this),
        ];
    }
}
