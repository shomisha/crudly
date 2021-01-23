<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\Views\AssertViewIsCreate;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadCreatePageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class CreateTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getAuthorizeUserDeveloper(),
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
            $this->getAssertResponseSuccessfulDeveloper(),
            $this->instantiateDeveloperWithManager(AssertViewIsCreate::class, $this)
        ];
    }
}
