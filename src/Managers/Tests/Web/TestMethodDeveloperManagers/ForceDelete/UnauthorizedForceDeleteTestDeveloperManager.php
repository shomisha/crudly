<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\ForceDelete;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedForceDeleteTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndDeauthorizeUserDeveloper(),
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
            $this->getAssertResponseForbiddenDeveloper(),
            $this->getRefreshModelDeveloper(),
            $this->instantiateDeveloperWithManager(AssertSoftDeletedColumnIsNull::class, $this),
        ];
    }
}
