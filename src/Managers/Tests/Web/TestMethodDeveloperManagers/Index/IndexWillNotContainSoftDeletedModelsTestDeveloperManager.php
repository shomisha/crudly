<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelsMissingSingularModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateMultipleModelInstances;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetModelIdsFromResponseDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\GetIndexRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexWillNotContainSoftDeletedModelsTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateMultipleModelInstances::class, $this),
            $this->instantiateDeveloperWithManager(CreateSoftDeletedInstance::class, $this),
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
            $this->getAssertResponseSuccessfulDeveloper(),
            $this->instantiateDeveloperWithManager(AssertViewIsDeveloper::class, $this)->using(['view' => 'index']),
            $this->instantiateDeveloperWithManager(GetModelIdsFromResponseDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertResponseModelsMissingSingularModel::class, $this),
        ];
    }
}
