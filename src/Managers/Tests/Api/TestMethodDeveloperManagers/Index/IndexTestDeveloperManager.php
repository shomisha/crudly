<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIdsCountSameAsModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertJsonResponseContainsAllModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateMultipleModelInstances;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetModelIdsFromJsonDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateMultipleModelInstances::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(GetIndexRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertResponseStatusDeveloper::class, $this)->using(['status' => 200]),
            $this->instantiateDeveloperWithManager(GetModelIdsFromJsonDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertResponseModelIdsCountSameAsModels::class, $this),
            $this->instantiateDeveloperWithManager(AssertJsonResponseContainsAllModels::class, $this)
        ];
    }
}
