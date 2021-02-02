<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIdsCountSameAsModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertJsonResponseContainsAllModels;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusOkDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateMultipleModelInstances;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetModelIdsFromJsonDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadIndexPageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateMultipleModelInstances::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(LoadIndexPageDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertResponseStatusOkDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(GetModelIdsFromJsonDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertResponseModelIdsCountSameAsModels::class, $this),
            $this->instantiateDeveloperWithManager(AssertJsonResponseContainsAllModels::class, $this)
        ];
    }
}
