<?php

namespace Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Show;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelIsJsonModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseStatusDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\GetShowRouteDeveloper;
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
            $this->instantiateDeveloperWithManager(GetShowRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(AssertResponseStatusDeveloper::class, $this)->using(['status' => 200]),
            $this->instantiateDeveloperWithManager(AssertModelIsJsonModel::class, $this),
        ];
    }
}
