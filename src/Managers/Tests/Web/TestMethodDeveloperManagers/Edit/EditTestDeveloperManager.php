<?php

namespace Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIsTestModel;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\Views\AssertViewIsEdit;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSingleModelInstance;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadEditPageDeveloper;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;

class EditTestDeveloperManager extends TestMethodDeveloperManager
{
    public function getArrangeDevelopers(): array
    {
        return [
            $this->getCreateAndAuthenticateUserDeveloper(),
            $this->getAuthorizeUserDeveloper(),
            $this->instantiateDeveloperWithManager(CreateSingleModelInstance::class, $this),
        ];
    }

    public function getActDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(LoadEditPageDeveloper::class, $this),
        ];
    }

    public function getAssertDevelopers(): array
    {
        return [
            $this->getAssertResponseSuccessfulDeveloper(),
            $this->instantiateDeveloperWithManager(AssertViewIsEdit::class, $this),
            $this->instantiateDeveloperWithManager(AssertResponseModelIsTestModel::class, $this),
        ];
    }
}