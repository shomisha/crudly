<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Update;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelHasOldValuesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSessionHasFieldErrorDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithInvalidOverrideDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class InvalidUpdateTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateModelWithOldDefaultsDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(GetDataWithInvalidOverrideDeveloper::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(PutDataToUpdateRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertSessionHasFieldErrorDeveloper::class, $this),
            $this->getRefreshModelDeveloper(),
            $this->instantiateDeveloperWithManager(AssertModelHasOldValuesDeveloper::class, $this),
        ];
    }
}
