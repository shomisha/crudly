<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelNotDeletedDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedDestroyTestDeveloperManager extends TestMethodDeveloperManager
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
            $this->instantiateDeveloperWithManager(DeleteDestroyRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseForbiddenDeveloper(),
            $this->instantiateDeveloperWithManager(AssertModelNotDeletedDeveloper::class, $this),
        ];
    }
}
