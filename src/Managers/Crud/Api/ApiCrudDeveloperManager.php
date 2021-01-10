<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Destroy\DestroyDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\ForceDelete\ForceDeleteDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Index\IndexDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Restore\RestoreDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Show\ShowDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Store\StoreDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Update\UpdateDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class ApiCrudDeveloperManager extends BaseDeveloperManager
{
    public function getIndexMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(IndexDeveloper::class, $this->getIndexManager());
    }

    public function getIndexManager(): IndexMethodDeveloperManager
    {
        return $this->instantiateManager(IndexMethodDeveloperManager::class);
    }

    public function getShowMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ShowDeveloper::class, $this->getShowManager());
    }

    public function getShowManager(): ShowMethodDeveloperManager
    {
        return $this->instantiateManager(ShowMethodDeveloperManager::class);
    }

    public function getStoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreDeveloper::class, $this->getStoreManager());
    }

    public function getStoreManager(): StoreMethodDeveloperManager
    {
        return $this->instantiateManager(StoreMethodDeveloperManager::class);
    }

    public function getUpdateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateDeveloper::class, $this->getUpdateManager());
    }

    public function getUpdateManager(): UpdateMethodDeveloperManager
    {
        return $this->instantiateManager(UpdateMethodDeveloperManager::class);
    }

    public function getDestroyMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(DestroyDeveloper::class, $this->getDestroyManager());
    }

    public function getDestroyManager(): DestroyMethodDeveloperManager
    {
        return $this->instantiateManager(DestroyMethodDeveloperManager::class);
    }

    public function getForceDeleteMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ForceDeleteDeveloper::class, $this->getForceDeleteManager());
    }

    public function getForceDeleteManager(): ForceDeleteMethodDeveloperManager
    {
        return $this->instantiateManager(ForceDeleteMethodDeveloperManager::class);
    }

    public function getRestoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreDeveloper::class, $this->getRestoreManager());
    }

    public function getRestoreManager(): RestoreMethodDeveloperManager
    {
        return $this->instantiateManager(RestoreMethodDeveloperManager::class);
    }
}
