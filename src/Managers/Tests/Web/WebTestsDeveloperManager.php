<?php

namespace Shomisha\Crudly\Managers\Tests\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\UnauthorizedIndexTestDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class WebTestsDeveloperManager extends BaseDeveloperManager
{
    public function getIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedIndexTestDeveloper::class, $this->getUnauthorizedIndexTestDeveloperManager());
    }

    public function getShowTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedShowTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getCreateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedCreateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getStoreInvalidDataProviderDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getInvalidDataStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getEditTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedEditTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUpdateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUpdateInvalidDataProviderDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getInvalidDataUpdateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedUpdateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getDestroyTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedDestroyTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getForceDeleteTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedForceDeleteTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getRestoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedRestoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }
}
