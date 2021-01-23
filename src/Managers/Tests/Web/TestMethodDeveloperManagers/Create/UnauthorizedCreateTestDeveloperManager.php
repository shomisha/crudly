<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadCreatePageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedCreateTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getDeauthorizeUserDeveloper(),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(LoadCreatePageDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseForbiddenDeveloper(),
        ];
    }
}
