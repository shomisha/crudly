<?php

namespace Shomisha\Crudly\Managers\Tests\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Developers\Tests\Web\Methods as TestMethods;
use Shomisha\Crudly\Managers\Tests\TestClassDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers as TestManagers;

class WebTestsDeveloperManager extends TestClassDeveloperManager
{
    /** @return \Shomisha\Crudly\Abstracts\Developer[] */
    public function getRouteMethodDevelopers(): array
    {
        return $this->instantiateGroupOfDevelopersByKey('web.tests.helpers.routes');
    }

    public function getIndexTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.index',
            $this->instantiateManager(TestManagers\Index\IndexTestDeveloperManager::class)
        );
    }

    public function getIndexWillNotContainSoftDeletedModelsTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.index.missing-soft-deleted',
            $this->instantiateManager(TestManagers\Index\IndexWillNotContainSoftDeletedModelsTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.index.unauthorized',
            $this->instantiateManager(TestManagers\Index\UnauthorizedIndexTestDeveloperManager::class)
        );
    }

    public function getShowTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.show',
            $this->instantiateManager(TestManagers\Show\ShowTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedShowTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.show.unauthorized',
            $this->instantiateManager(TestManagers\Show\UnauthorizedShowTestDeveloperManager::class)
        );
    }

    public function getCreateTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.create',
            $this->instantiateManager(TestManagers\Create\CreateTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedCreateTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.create.unauthorized',
            $this->instantiateManager(TestManagers\Create\UnauthorizedCreateTestDeveloperManager::class)
        );
    }

    public function getStoreTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.store',
            $this->instantiateManager(TestManagers\Store\StoreTestDeveloperManager::class)
        );
    }

    public function getInvalidDataProviderDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(
            TestMethods\InvalidDataProviderDeveloper::class,
            $this
        );
    }

    public function getInvalidDataStoreTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.store.invalid',
            $this->instantiateManager(TestManagers\Store\InvalidDataStoreTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedStoreTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.store.unauthorized',
            $this->instantiateManager(TestManagers\Store\UnauthorizedStoreTestDeveloperManager::class)
        );
    }

    public function getEditTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.edit',
            $this->instantiateManager(TestManagers\Edit\EditTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedEditTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.edit.unauthorized',
            $this->instantiateManager(TestManagers\Edit\UnauthorizedEditTestDeveloperManager::class)
        );
    }

    public function getUpdateTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.update',
            $this->instantiateManager(TestManagers\Update\UpdateTestDeveloperManager::class)
        );
    }

    public function getInvalidDataUpdateTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.update.invalid',
            $this->instantiateManager(TestManagers\Update\InvalidUpdateTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedUpdateTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.update.unauthorized',
            $this->instantiateManager(TestManagers\Update\UnauthorizedUpdateTestDeveloperManager::class)
        );
    }

    public function getDestroyTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.destroy',
            $this->instantiateManager(TestManagers\Destroy\DestroyTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedDestroyTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.destroy.unauthorized',
            $this->instantiateManager(TestManagers\Destroy\UnauthorizedDestroyTestDeveloperManager::class)
        );
    }

    public function getForceDeleteTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.force-delete',
            $this->instantiateManager(TestManagers\ForceDelete\ForceDeleteTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedForceDeleteTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.force-delete.unauthorized',
            $this->instantiateManager(TestManagers\ForceDelete\UnauthorizedForceDeleteTestDeveloperManager::class)
        );
    }

    public function getRestoreTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.restore',
            $this->instantiateManager(TestManagers\Restore\RestoreTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedRestoreTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests.restore.unauthorized',
            $this->instantiateManager(TestManagers\Restore\UnauthorizedRestoreTestDeveloperManager::class)
        );
    }
}
