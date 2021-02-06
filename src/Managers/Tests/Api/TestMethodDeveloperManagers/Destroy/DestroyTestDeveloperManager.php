<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelDeletedDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class DestroyTestDeveloperManager extends TestMethodDeveloperManager
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
            $this->instantiateDeveloperWithManager(DeleteDestroyRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertResponseStatusDeveloper::class, $this)->using(['status' => 204]),
            $this->instantiateDeveloperWithManager(AssertModelDeletedDeveloper::class, $this),
        ];
    }
}
