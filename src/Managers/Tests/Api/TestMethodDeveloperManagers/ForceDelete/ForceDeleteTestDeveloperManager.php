<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\ForceDelete;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusUpdatedDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNotNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class ForceDeleteTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->getCreateSingleInstanceDeveloper(),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(DeleteForceDeleteRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertResponseStatusUpdatedDeveloper::class, $this),
            $this->getRefreshModelDeveloper(),
            $this->instantiateDeveloperWithManager(AssertSoftDeletedColumnIsNotNull::class, $this),
        ];
    }
}
