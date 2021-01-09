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

    public function getIndexManager(): IndexDeveloperManager
    {
        return $this->instantiateManager(IndexDeveloperManager::class);
    }

    public function getShowMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ShowDeveloper::class, $this->getShowManager());
    }

    public function getShowManager(): ShowDeveloperManager
    {
        return $this->instantiateManager(ShowDeveloperManager::class);
    }

    public function getCreateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateDeveloper::class, $this->getCreateManager());
    }

    public function getCreateManager(): CreateDeveloperManager
    {
        return $this->instantiateManager(CreateDeveloperManager::class);
    }

    public function getStoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreDeveloper::class, $this->getStoreManager());
    }

    public function getStoreManager(): StoreDeveloperManager
    {
        return $this->instantiateManager(StoreDeveloperManager::class);
    }

    public function getEditMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(EditDeveloper::class, $this->getEditManager());
    }

    public function getEditManager(): EditDeveloperManager
    {
        return $this->instantiateManager(EditDeveloperManager::class);
    }

    public function getUpdateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UpdateDeveloper::class, $this->getUpdateManager());
    }

    public function getUpdateManager(): UpdateDeveloperManager
    {
        return $this->instantiateManager(UpdateDeveloperManager::class);
    }

    public function getDestroyMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(DestroyDeveloper::class, $this->getDestroyManager());
    }

    public function getDestroyManager(): DestroyDeveloperManager
    {
        return $this->instantiateManager(DestroyDeveloperManager::class);
    }

    public function getRestoreDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreDeveloper::class, $this->getRestoreManager());
    }

    public function getRestoreManager(): RestoreDeveloperManager
    {
        return $this->instantiateManager(RestoreDeveloperManager::class);
    }

    public function getForceDeleteDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ForceDeleteDeveloper::class, $this->getForceDeleteManager());
    }

    public function getForceDeleteManager(): ForceDeleteDeveloperManager
    {
        return $this->instantiateManager(ForceDeleteDeveloperManager::class);
    }
}
