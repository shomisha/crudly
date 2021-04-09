<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class WebCrudDeveloperManager extends BaseDeveloperManager
{
    public function getIndexMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.index', $this->getIndexManager());
    }

    public function getIndexManager(): IndexMethodDeveloperManager
    {
        return $this->instantiateManager(IndexMethodDeveloperManager::class);
    }

    public function getShowMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.show', $this->getShowManager());
    }

    public function getShowManager(): ShowMethodDeveloperManager
    {
        return $this->instantiateManager(ShowMethodDeveloperManager::class);
    }

    public function getCreateMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.create', $this->getCreateManager());
    }

    public function getCreateManager(): CreateMethodDeveloperManager
    {
        return $this->instantiateManager(CreateMethodDeveloperManager::class);
    }

    public function getStoreMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.store', $this->getStoreManager());
    }

    public function getStoreManager(): StoreMethodDeveloperManager
    {
        return $this->instantiateManager(StoreMethodDeveloperManager::class);
    }

    public function getEditMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.edit', $this->getEditManager());
    }

    public function getEditManager(): EditMethodDeveloperManager
    {
        return $this->instantiateManager(EditMethodDeveloperManager::class);
    }

    public function getUpdateMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.update', $this->getUpdateManager());
    }

    public function getUpdateManager(): UpdateMethodDeveloperManager
    {
        return $this->instantiateManager(UpdateMethodDeveloperManager::class);
    }

    public function getDestroyMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.destroy', $this->getDestroyManager());
    }

    public function getDestroyManager(): DestroyMethodDeveloperManager
    {
        return $this->instantiateManager(DestroyMethodDeveloperManager::class);
    }

    public function getForceDeleteDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.force-delete', $this->getForceDeleteManager());
    }

    public function getForceDeleteManager(): ForceDeleteMethodDeveloperManager
    {
        return $this->instantiateManager(ForceDeleteMethodDeveloperManager::class);
    }

    public function getRestoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('web.controller.restore', $this->getRestoreManager());
    }

    public function getRestoreManager(): RestoreMethodDeveloperManager
    {
        return $this->instantiateManager(RestoreMethodDeveloperManager::class);
    }
}
