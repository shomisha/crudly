<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertAllModelIdsPresentDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\Views\AssertViewIsIndex;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateMultipleModelInstances;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadIndexPageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class IndexTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        // TODO: refactor this to support overriding developers
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateMultipleModelInstances::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        // TODO: refactor this to support overriding developers
        return [
            $this->instantiateDeveloperWithManager(LoadIndexPageDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        // TODO: refactor this to support overriding developers
        return [
            $this->getAssertResponseSuccessfulDeveloper(),
            $this->instantiateDeveloperWithManager(AssertViewIsIndex::class, $this),
            $this->instantiateDeveloperWithManager(AssertAllModelIdsPresentDeveloper::class, $this),
        ];
    }
}
