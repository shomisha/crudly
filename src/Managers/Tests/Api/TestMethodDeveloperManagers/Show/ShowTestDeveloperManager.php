<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Show;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelIsJsonModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusOkDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadShowPageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class ShowTestDeveloperManager extends TestMethodDeveloperManager
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
            $this->instantiateDeveloperWithManager(LoadShowPageDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertResponseStatusOkDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(AssertModelIsJsonModel::class, $this),
        ];
    }
}
