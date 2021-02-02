<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertSoftDeletedColumnIsNull;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PatchRestoreRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class RestoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateSoftDeletedInstance::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(PatchRestoreRouteDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertRedirectToIndexDeveloper(),
            $this->getRefreshModelDeveloper(),
            $this->instantiateDeveloperWithManager(AssertSoftDeletedColumnIsNull::class, $this),
        ];
    }
}
