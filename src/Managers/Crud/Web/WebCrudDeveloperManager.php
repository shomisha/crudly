<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\Destroy\DestroyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Edit\EditDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Create\CreateDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\ForceDelete\ForceDeleteDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Index\IndexDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Restore\RestoreDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Show\ShowDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Update\UpdateDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\Store\StoreDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class WebCrudDeveloperManager extends BaseDeveloperManager
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

    public function getCreateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateDeveloper::class, $this->getCreateManager());
    }

    public function getCreateManager(): CreateMethodDeveloperManager
    {
        return $this->instantiateManager(CreateMethodDeveloperManager::class);
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

    public function getEditMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(EditDeveloper::class, $this->getEditManager());
    }

    public function getEditManager(): EditMethodDeveloperManager
    {
        return $this->instantiateManager(EditMethodDeveloperManager::class);
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

    public function getForceDeleteDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ForceDeleteDeveloper::class, $this->getForceDeleteManager());
    }

    public function getForceDeleteManager(): ForceDeleteMethodDeveloperManager
    {
        return $this->instantiateManager(ForceDeleteMethodDeveloperManager::class);
    }

    public function getRestoreDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreDeveloper::class, $this->getRestoreManager());
    }

    public function getRestoreManager(): RestoreMethodDeveloperManager
    {
        return $this->instantiateManager(RestoreMethodDeveloperManager::class);
    }
}
