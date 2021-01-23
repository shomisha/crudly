<?php

namespace Shomisha\Crudly\Managers\Tests\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\AuthenticateUserMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\AuthorizeUserMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\DeauthorizeUserMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataPrimeDefaultsDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataSpecialDefaultsDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\IndexTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\UnauthorizedIndexTestDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\IndexTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\UnauthorizedIndexTestDeveloperManager;

class WebTestsDeveloperManager extends BaseDeveloperManager
{
    public function getAuthenticateUserMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(AuthenticateUserMethodDeveloper::class, $this);
    }

    public function getAuthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(AuthorizeUserMethodDeveloper::class, $this);
    }

    public function getDeauthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(DeauthorizeUserMethodDeveloper::class, $this);
    }

    public function getDataMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetModelDataMethodDeveloper::class, $this);
    }

    public function getModelDataSpecialDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetModelDataSpecialDefaultsDeveloper::class, $this);
    }

    public function getModelDataPrimeDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetModelDataPrimeDefaultsDeveloper::class, $this);
    }

    /** @return \Shomisha\Crudly\Abstracts\Developer[] */
    public function getRouteMethodDevelopers(): array
    {
        // TODO: refactor this to support overriding developers
        return [
            $this->instantiateDeveloperWithManager(RouteGetters\GetIndexRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetShowRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetCreateRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetStoreRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetEditRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetUpdateRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetDestroyRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetForceDeleteRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetRestoreRouteMethodDeveloper::class, $this),
        ];
    }

    public function getIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(IndexTestDeveloper::class, $this->getIndexTestDeveloperManager());
    }

    private function getIndexTestDeveloperManager(): IndexTestDeveloperManager
    {
        return $this->instantiateManager(IndexTestDeveloperManager::class);
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedIndexTestDeveloper::class, $this->getUnauthorizedIndexTestDeveloperManager());
    }

    private function getUnauthorizedIndexTestDeveloperManager(): UnauthorizedIndexTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedIndexTestDeveloperManager::class);
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