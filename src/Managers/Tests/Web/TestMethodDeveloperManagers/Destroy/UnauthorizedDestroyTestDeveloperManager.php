<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Destroy;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\SendDestroyRequest;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedDestroyTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getDeauthorizeUserDeveloper(),
            $this->getCreateSingleInstanceDeveloper(),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(SendDestroyRequest::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseForbiddenDeveloper(),
        ];
    }
}
