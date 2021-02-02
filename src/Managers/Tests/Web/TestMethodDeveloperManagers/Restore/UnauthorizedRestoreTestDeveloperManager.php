<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSoftDeletedInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\SendRestoreRequest;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class UnauthorizedRestoreTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getAuthenticateAndDeauthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateSoftDeletedInstance::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(SendRestoreRequest::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseForbiddenDeveloper(),
            $this->getRefreshModelDeveloper(),
            $this->getAssertSoftDeletedColumnIsNotNullDeveloper(),
        ];
    }
}
