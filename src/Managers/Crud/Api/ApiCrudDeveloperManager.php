<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class ApiCrudDeveloperManager extends BaseDeveloperManager
{
    public function getIndexMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.index', $this->getIndexManager());
    }

    public function getIndexManager(): IndexMethodDeveloperManager
    {
        return $this->instantiateManager(IndexMethodDeveloperManager::class);
    }

    public function getShowMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.show', $this->getShowManager());
    }

    public function getShowManager(): ShowMethodDeveloperManager
    {
        return $this->instantiateManager(ShowMethodDeveloperManager::class);
    }

    public function getStoreMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.store', $this->getStoreManager());
    }

    public function getStoreManager(): StoreMethodDeveloperManager
    {
        return $this->instantiateManager(StoreMethodDeveloperManager::class);
    }

    public function getUpdateMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.update', $this->getUpdateManager());
    }

    public function getUpdateManager(): UpdateMethodDeveloperManager
    {
        return $this->instantiateManager(UpdateMethodDeveloperManager::class);
    }

    public function getDestroyMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.destroy', $this->getDestroyManager());
    }

    public function getDestroyManager(): DestroyMethodDeveloperManager
    {
        return $this->instantiateManager(DestroyMethodDeveloperManager::class);
    }

    public function getForceDeleteMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.force-delete', $this->getForceDeleteManager());
    }

    public function getForceDeleteManager(): ForceDeleteMethodDeveloperManager
    {
        return $this->instantiateManager(ForceDeleteMethodDeveloperManager::class);
    }

    public function getRestoreMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('api.controller.restore', $this->getRestoreManager());
    }

    public function getRestoreManager(): RestoreMethodDeveloperManager
    {
        return $this->instantiateManager(RestoreMethodDeveloperManager::class);
    }
}
