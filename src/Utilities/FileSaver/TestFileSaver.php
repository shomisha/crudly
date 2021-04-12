<?php

namespace Shomisha\Crudly\Utilities\FileSaver;

use Shomisha\Crudly\Data\CrudlySet;

class TestFileSaver extends FileSaver
{
    private array $saved = [];

    public function __construct()
    {
    }

    protected function saveMigration(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('migration', $developedSet->getMigration());
    }

    public function getSavedMigrations(): array
    {
        return $this->saved['migration'] ?? [];
    }

    protected function saveModel(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('model', $developedSet->getModel());
    }

    public function getSavedModels(): array
    {
        return $this->saved['model'] ?? [];
    }

    protected function saveFactory(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('factories', $developedSet->getFactory());
    }

    public function getSavedFactories(): array
    {
        return $this->saved['factories'] ?? [];
    }

    protected function savePolicy(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('policy', $developedSet->getPolicy());
    }

    public function getSavedPolicies(): array
    {
        return $this->saved['policy'] ?? [];
    }

    protected function saveWebController(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('web-controller', $developedSet->getWebCrudController());
    }

    public function getSavedWebControllers(): array
    {
        return $this->saved['web-controller'] ?? [];
    }

    protected function saveWebFormRequest(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('web-form-request', $developedSet->getWebCrudFormRequest());
    }

    public function getSavedWebFormRequests(): array
    {
        return $this->saved['web-form-request'] ?? [];
    }

    protected function saveWebTests(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('web-tests', $developedSet->getWebTests());
    }

    public function getSavedWebTests(): array
    {
        return $this->saved['web-tests'] ?? [];
    }

    protected function saveApiController(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('api-controllers', $developedSet->getApiCrudController());
    }

    public function getSavedApiControllers(): array
    {
        return $this->saved['api-controllers'] ?? [];
    }

    protected function saveApiTests(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('api-tests', $developedSet->getApiTests());
    }

    public function getSavedApiTests(): array
    {
        return $this->saved['api-tests'] ?? [];
    }

    protected function saveApiFormRequest(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('api-form-request', $developedSet->getApiCrudFormRequest());
    }

    public function getSavedApiFormRequests(): array
    {
        return $this->saved['api-form-request'] ?? [];
    }

    protected function saveApiResource(CrudlySet $developedSet): bool
    {
        return $this->appendSaved('api-resource', $developedSet->getApiCrudApiResource());
    }

    public function getSavedApiResources(): array
    {
        return $this->saved['api-resource'] ?? [];
    }

    private function appendSaved(string $key, $target): bool
    {
        $this->saved[$key] = array_merge(
            $this->saved[$key] ?? [],
            [$target]
        );

        return true;
    }
}
