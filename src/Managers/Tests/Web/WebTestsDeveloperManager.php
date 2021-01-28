<?php

namespace Shomisha\Crudly\Managers\Tests\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers as TestHelpers;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Developers\Tests\Web\Methods as TestMethods;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers as TestManagers;

class WebTestsDeveloperManager extends BaseDeveloperManager
{
    public function getAuthenticateUserMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\AuthenticateUserMethodDeveloper::class, $this);
    }

    public function getAuthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\AuthorizeUserMethodDeveloper::class, $this);
    }

    public function getDeauthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\DeauthorizeUserMethodDeveloper::class, $this);
    }

    public function getDataMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\GetModelDataMethodDeveloper::class, $this);
    }

    public function getModelDataSpecialDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\GetModelDataSpecialDefaultsDeveloper::class, $this);
    }

    public function getModelDataPrimeDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(TestHelpers\GetModelDataPrimeDefaultsDeveloper::class, $this);
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
        return $this->instantiateDeveloperWithManager(
            TestMethods\Index\IndexTestDeveloper::class,
            $this->instantiateManager(TestManagers\Index\IndexTestDeveloperManager::class)
        );
    }

    public function getIndexWillNotContainSoftDeletedModelsTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Index\IndexWillNotContainSoftDeletedModelsTestDeveloper::class,
            $this->instantiateManager(TestManagers\Index\IndexWillNotContainSoftDeletedModelsTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Index\UnauthorizedIndexTestDeveloper::class,
            $this->instantiateManager(TestManagers\Index\UnauthorizedIndexTestDeveloperManager::class)
        );
    }

    public function getShowTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Show\ShowTestDeveloper::class,
            $this->instantiateManager(TestManagers\Show\ShowTestDeveloperManager::class));
    }

    public function getUnauthorizedShowTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Show\UnauthorizedShowTestDeveloper::class,
            $this->instantiateManager(TestManagers\Show\UnauthorizedShowTestDeveloperManager::class)
        );
    }

    public function getCreateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Create\CreateTestDeveloper::class,
            $this->instantiateManager(TestManagers\Create\CreateTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedCreateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Create\UnauthorizedCreateTestDeveloper::class,
            $this->instantiateManager(TestManagers\Create\UnauthorizedCreateTestDeveloperManager::class)
        );
    }

    public function getStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Store\StoreTestDeveloper::class,
            $this->instantiateManager(TestManagers\Store\StoreTestDeveloperManager::class)
        );
    }

    public function getStoreInvalidDataProviderDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Store\InvalidStoreDataProviderDeveloper::class,
            $this
        );
    }

    public function getInvalidDataStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Store\InvalidStoreTestDeveloper::class,
            $this->instantiateManager(TestManagers\Store\InvalidDataStoreTestDeveloperManager::class),
        );
    }

    public function getUnauthorizedStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Store\UnauthorizedStoreTestDeveloper::class,
            $this->instantiateManager(TestManagers\Store\UnauthorizedStoreTestDeveloperManager::class)
        );
    }

    public function getEditTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Edit\EditTestDeveloper::class,
            $this->instantiateManager(TestManagers\Edit\EditTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedEditTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Edit\UnauthorizedEditTestDeveloper::class,
            $this->instantiateManager(TestManagers\Edit\UnauthorizedEditTestDeveloperManager::class)
        );
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
        return $this->instantiateDeveloperWithManager(
            TestMethods\Destroy\DestroyTestDeveloper::class,
            $this->instantiateManager(TestManagers\Destroy\DestroyTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedDestroyTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Destroy\UnauthorizedDestroyTestDeveloper::class,
            $this->instantiateManager(TestManagers\Destroy\UnauthorizedDestroyTestDeveloperManager::class)
        );
    }

    public function getForceDeleteTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\ForceDelete\ForceDeleteTestDeveloper::class,
            $this->instantiateManager(TestManagers\ForceDelete\ForceDeleteTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedForceDeleteTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\ForceDelete\UnauthorizedForceDeleteTestDeveloper::class,
            $this->instantiateManager(TestManagers\ForceDelete\UnauthorizedForceDeleteTestDeveloperManager::class)
        );
    }

    public function getRestoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Restore\RestoreTestDeveloper::class,
            $this->instantiateManager(TestManagers\Restore\RestoreTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedRestoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\Restore\UnauthorizedRestoreTestDeveloper::class,
            $this->instantiateManager(TestManagers\Restore\UnauthorizedRestoreTestDeveloperManager::class)
        );
    }
}
