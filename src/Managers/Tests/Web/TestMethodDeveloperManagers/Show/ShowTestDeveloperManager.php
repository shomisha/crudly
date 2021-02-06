<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Show;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIsTestModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertViewIsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSingleModelInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\GetShowRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class ShowTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateSingleModelInstance::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(GetShowRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseSuccessfulDeveloper(),
            $this->instantiateDeveloperWithManager(AssertViewIsDeveloper::class, $this)->using(['view' => 'show']),
            $this->instantiateDeveloperWithManager(AssertResponseModelIsTestModel::class, $this),
        ];
    }
}
