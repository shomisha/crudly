<?php

namespace Shomisha\Crudly\Managers\Tests\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\Web\Methods\InvalidDataProviderDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers as MethodDeveloperManagers;
use Shomisha\Crudly\Managers\Tests\TestClassDeveloperManager;

class ApiTestsDeveloperManager extends TestClassDeveloperManager
{
    public function getRouteMethodDevelopers(): array
    {
        return $this->instantiateGroupOfDevelopersByKey('api.tests.helpers.routes');
    }

    public function getIndexTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.index',
            $this->instantiateManager(MethodDeveloperManagers\Index\IndexTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.index.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\Index\UnauthorizedIndexTestDeveloperManager::class)
        );
    }

    public function getShowDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.show',
            $this->instantiateManager(MethodDeveloperManagers\Show\ShowTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedShowDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.show.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\Show\UnauthorizedShowTestDeveloperManager::class)
        );
    }

    public function getStoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.store',
            $this->instantiateManager(MethodDeveloperManagers\Store\StoreTestDeveloperManager::class)
        );
    }

    public function getInvalidDataProviderDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            InvalidDataProviderDeveloper::class,
            $this,
        );
    }

    public function getInvalidStoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.store.invalid',
            $this->instantiateManager(MethodDeveloperManagers\Store\InvalidStoreTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedStoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.store.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\Store\UnauthorizedStoreTestDeveloperManager::class)
        );
    }

    public function getUpdateDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.update',
            $this->instantiateManager(MethodDeveloperManagers\Update\UpdateTestDeveloperManager::class)
        );
    }

    public function getInvalidUpdateDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.update.invalid',
            $this->instantiateManager(MethodDeveloperManagers\Update\InvalidUpdateTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedUpdateDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.update.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\Update\UnauthorizedUpdateTestDeveloperManager::class)
        );
    }

    public function getDestroyDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.destroy',
            $this->instantiateManager(MethodDeveloperManagers\Destroy\DestroyTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedDestroyDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.destroy.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\Destroy\UnauthorizedDestroyTestDeveloperManager::class)
        );
    }

    public function getForceDeleteDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.force-delete',
            $this->instantiateManager(MethodDeveloperManagers\ForceDelete\ForceDeleteTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedForceDeleteDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.force-delete.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\ForceDelete\UnauthorizedForceDeleteTestDeveloperManager::class)
        );
    }

    public function getRestoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.restore',
            $this->instantiateManager(MethodDeveloperManagers\Restore\RestoreTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedRestoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests.restore.unauthorized',
            $this->instantiateManager(MethodDeveloperManagers\Restore\UnauthorizedRestoreTestDeveloperManager::class)
        );
    }
}
