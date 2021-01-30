<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Update;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelUpdatedWithNewValuesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\SendUpdateDataRequest;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UpdateTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateModelWithOldDefaultsDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(GetDataWithNewDefaultsDeveloper::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(SendUpdateDataRequest::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertRedirectToIndexDeveloper(),
            $this->getAssertSessionHasSuccessDeveloper(),
            $this->getRefreshModelDeveloper(),
            $this->instantiateDeveloperWithManager(AssertModelUpdatedWithNewValuesDeveloper::class, $this),
        ];
    }
}
