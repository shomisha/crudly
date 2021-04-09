<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\Crud\Api\ApiCrudDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager;
use Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager;
use Shomisha\Crudly\Managers\Crud\Web\WebCrudDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Api\ApiTestsDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\WebTestsDeveloperManager;

class DeveloperManager extends BaseDeveloperManager
{
    public function getModelDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'model', $this->getModelManager()
        );
    }

    private function getModelManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(ModelDeveloperManager::class);
    }

    public function getMigrationDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'migrations', $this->getMigrationManager()
        );
    }

    private function getMigrationManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(MigrationDeveloperManager::class);
    }

    public function getFactoryDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'factory', $this->getFactoryManager()
        );
    }

    private function getFactoryManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(FactoryDeveloperManager::class);
    }

    public function getWebCrudFormRequestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.form-request', $this->getFormRequestDeveloperManager()
        );
    }

    public function getWebCrudControllerDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.controller', $this->getWebCrudManager()
        );
    }

    public function getWebTestsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'web.tests', $this->getWebTestsManager()
        );
    }

    public function getApiCrudFormRequestDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.form-request', $this->getFormRequestDeveloperManager()
        );
    }

    public function getApiCrudApiResourceDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.resource', $this->getApiResourceDeveloperManager()
        );
    }

    public function getApiCrudControllerDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.controller', $this->getApiCrudManager()
        );
    }

    public function getApiTestsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            'api.tests', $this->getApiTestsDeveloperManager()
        );
    }

    public function getPolicyDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('policy');
    }

    private function getWebCrudManager(): WebCrudDeveloperManager
    {
        return $this->instantiateManager(WebCrudDeveloperManager::class);
    }

    private function getWebTestsManager(): WebTestsDeveloperManager
    {
        return $this->instantiateManager(WebTestsDeveloperManager::class);
    }

    private function getApiTestsDeveloperManager(): ApiTestsDeveloperManager
    {
        return $this->instantiateManager(ApiTestsDeveloperManager::class);
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
}
