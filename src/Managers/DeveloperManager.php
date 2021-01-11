<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\Resource\ApiResourceDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\CrudControllerDeveloper as ApiCrudControllerDeveloper;
use Shomisha\Crudly\Developers\Migration\MigrationDeveloper;
use Shomisha\Crudly\Developers\Model\ModelDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\CrudControllerDeveloper as WebCrudControllerDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\CrudFormRequestDeveloper;
use Shomisha\Crudly\Managers\Crud\Api\ApiCrudDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\WebCrudDeveloperManager;

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
        return $this->instantiateDeveloperWithManager(CrudFormRequestDeveloper::class, $this->getWebCrudManager());
    }

    public function getWebCrudControllerDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(WebCrudControllerDeveloper::class, $this->getWebCrudManager());
    }

    public function getApiCrudFormRequestDeveloper(): Developer
    {

    }

    public function getApiCrudApiResourceDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ApiResourceDeveloper::class, $this->getApiResourceDeveloperManager());
    }

    public function getApiCrudControllerDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ApiCrudControllerDeveloper::class, $this->getApiCrudManager());
    }

    private function getWebCrudManager(): WebCrudDeveloperManager
    {
        return $this->instantiateManager(WebCrudDeveloperManager::class);
    }

    private function getApiCrudManager(): ApiCrudDeveloperManager
    {
        return $this->instantiateManager(ApiCrudDeveloperManager::class);
    }

    private function getApiResourceDeveloperManager(): ApiResourceDeveloperManager
    {
        return $this->instantiateManager(ApiResourceDeveloperManager::class);
    }
}
