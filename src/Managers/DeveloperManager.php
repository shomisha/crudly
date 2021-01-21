<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\CrudControllerDeveloper as ApiCrudControllerDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\FormRequest\ApiFormRequestDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\Resource\ApiResourceDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\CrudControllerDeveloper as WebCrudControllerDeveloper;
use Shomisha\Crudly\Developers\Crud\Web\FormRequest\WebFormRequestDeveloper;
use Shomisha\Crudly\Developers\Factory\FactoryClassDeveloper;
use Shomisha\Crudly\Developers\Migration\MigrationDeveloper;
use Shomisha\Crudly\Developers\Model\ModelDeveloper;
use Shomisha\Crudly\Managers\Crud\Api\ApiCrudDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager;
use Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager;
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

    public function getFactoryDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FactoryClassDeveloper::class, $this->getFactoryManager());
    }

    private function getFactoryManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(FactoryDeveloperManager::class);
    }

    public function getWebCrudFormRequestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(WebFormRequestDeveloper::class, $this->getFormRequestDeveloperManager());
    }

    public function getWebCrudControllerDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(WebCrudControllerDeveloper::class, $this->getWebCrudManager());
    }

    public function getWebTestsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getApiCrudFormRequestDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ApiFormRequestDeveloper::class, $this->getFormRequestDeveloperManager());
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

    public function getApiTestsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    private function getWebCrudManager(): WebCrudDeveloperManager
    {
        return $this->instantiateManager(WebCrudDeveloperManager::class);
    }

    private function getWebTestsManager()
    {

    }

    private function getFormRequestDeveloperManager(): FormRequestDeveloperManager
    {
        return $this->instantiateManager(FormRequestDeveloperManager::class);
    }

    private function getApiResourceDeveloperManager(): ApiResourceDeveloperManager
    {
        return $this->instantiateManager(ApiResourceDeveloperManager::class);
    }

    private function getApiCrudManager(): ApiCrudDeveloperManager
    {
        return $this->instantiateManager(ApiCrudDeveloperManager::class);
    }

    private function getApiTestsManager()
    {

    }
}
