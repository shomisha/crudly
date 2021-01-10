<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Index\IndexDeveloper;
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

    public function getStoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreDeveloper::class, $this->getStoreManager());
    }

    public function getStoreManager(): StoreDeveloperManager
    {
        return $this->instantiateManager(StoreDeveloperManager::class);
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
    }

    public function getForceDeleteMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getRestoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }
}
