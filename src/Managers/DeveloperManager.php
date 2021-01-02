<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Migration\MigrationDeveloper;
use Shomisha\Crudly\Developers\Model\ModelDeveloper;
use Shomisha\Crudly\Developers\WebCrud\WebCrudControllerDeveloper;
use Shomisha\Crudly\Developers\WebCrud\WebCrudFormRequestDeveloper;

class DeveloperManager extends BaseDeveloperManager
{
    public function getModelDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ModelDeveloper::class, ($this->getModelManager()));
    }

    private function getModelManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(ModelDeveloperManager::class);
    }

    public function getMigrationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(MigrationDeveloper::class, ($this->getMigrationManager()));
    }

    private function getMigrationManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(MigrationDeveloperManager::class);
    }

    public function getWebCrudFormRequestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(WebCrudFormRequestDeveloper::class, ($this->getWebCrudManager()));
    }

    public function getWebCrudControllerDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(WebCrudControllerDeveloper::class, ($this->getWebCrudManager()));
    }

    private function getWebCrudManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(WebCrudDeveloperManager::class);
    }
}
