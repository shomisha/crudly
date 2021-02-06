<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Update;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelUpdatedWithNewValuesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PutDataToUpdateRouteDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UpdateTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateModelWithOldDefaultsDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(GetDataWithNewDefaultsDeveloper::class, $this),
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
            $this->instantiateDeveloperWithManager(AssertResponseStatusDeveloper::class, $this)->using(['status' => 200]),
            $this->getRefreshModelDeveloper(),
            $this->instantiateDeveloperWithManager(AssertModelUpdatedWithNewValuesDeveloper::class, $this),
        ];
    }
}
