<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\ForceDelete;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseMissingModelDeveloper;
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
            $this->getAssertRedirectToIndexDeveloper(),
            $this->getAssertSessionHasSuccessDeveloper(),
            $this->instantiateDeveloperWithManager(AssertDatabaseMissingModelDeveloper::class, $this),
        ];
    }
}
