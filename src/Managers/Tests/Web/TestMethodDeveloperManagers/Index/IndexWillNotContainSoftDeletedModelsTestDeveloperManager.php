<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelsMissingSingularModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\Views\AssertViewIsIndex;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateMultipleModelInstances;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadIndexPageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexWillNotContainSoftDeletedModelsTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateMultipleModelInstances::class, $this),
            $this->instantiateDeveloperWithManager(CreateSoftDeletedInstance::class, $this),
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
            $this->getAssertResponseSuccessfulDeveloper(),
            $this->instantiateDeveloperWithManager(AssertViewIsIndex::class, $this),
            $this->instantiateDeveloperWithManager(AssertResponseModelsMissingSingularModel::class, $this),
        ];
    }
}
