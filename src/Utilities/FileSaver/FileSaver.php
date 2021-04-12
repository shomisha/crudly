<?php

namespace Shomisha\Crudly\Utilities\FileSaver;

use Illuminate\Support\Str;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Utilities\ModelSupervisor;

class FileSaver
{
    protected string $appRoot;

    protected string $projectRoot;

    protected ModelSupervisor $modelSupervisor;

    public function __construct(ModelSupervisor $modelSupervisor, string $projectRoot, string $appRoot)
    {
        $this->modelSupervisor = $modelSupervisor;
        $this->projectRoot = $projectRoot;
        $this->appRoot = $appRoot;
    }

    public function saveAllFiles(CrudlySet $developedSet): void
    {
        $this->saveMigration($developedSet);
        $this->saveModel($developedSet);
        $this->saveFactory($developedSet);

        if ($developedSet->getWebCrudController()) {
            $this->saveWebController($developedSet);
            $this->saveWebFormRequest($developedSet);

            if ($developedSet->getWebTests()) {
                $this->saveWebTests($developedSet);
            }
        }

        if ($developedSet->getApiCrudController()) {
            $this->saveApiController($developedSet);
            $this->saveApiResource($developedSet);
            $this->saveApiFormRequest($developedSet);

            if ($developedSet->getApiTests()) {
                $this->saveApiTests($developedSet);
            }
        }
    }

    protected function saveMigration(CrudlySet $developedSet): bool
    {
        return $developedSet->getMigration()->save(
            $this->joinPathComponentsAndExtension([
                $this->projectRoot,
                'database',
                'migrations',
                $this->guessMigrationFilename($developedSet),
            ])
        );
    }

    protected function saveModel(CrudlySet $developedSet): bool
    {
        $model = $developedSet->getModel();
        $components = [$this->appRoot];

        if ($this->modelSupervisor->shouldUseModelsDirectory()) {
            $components[] = 'Models';
        }

        $components[] = $model->getName();

        return $model->save(
            $this->joinPathComponentsAndExtension($components)
        );
    }

    protected function saveFactory(CrudlySet $developedSet): bool
    {
        $factory = $developedSet->getFactory();

        return $factory->save(
            $this->joinPathComponentsAndExtension([
                $this->projectRoot,
                'database',
                'factories',
                $factory->getName(),
            ])
        );
    }

    protected function saveWebController(CrudlySet $developedSet): bool
    {
        $controller = $developedSet->getWebCrudController();

        return $controller->save(
            $this->joinPathComponentsAndExtension([
                $this->appRoot,
                'Http',
                'Controllers',
                'Web',
                $controller->getName(),
            ])
        );
    }

    protected function saveWebFormRequest(CrudlySet $developedSet): bool
    {
        $formRequest = $developedSet->getWebCrudFormRequest();

        return $formRequest->save(
            $this->joinPathComponentsAndExtension([
                $this->appRoot,
                'Http',
                'Requests',
                'Web',
                $formRequest->getName(),
            ])
        );
    }

    protected function saveWebTests(CrudlySet $developedSet): bool
    {
        $webTests = $developedSet->getWebTests();

        return $webTests->save(
            $this->joinPathComponentsAndExtension([
                $this->projectRoot,
                'tests',
                'Feature',
                'Web',
                $webTests->getName()
            ])
        );
    }

    protected function saveApiController(CrudlySet $developedSet): bool
    {
        $apiController = $developedSet->getApiCrudController();

        return $apiController->save(
            $this->joinPathComponentsAndExtension([
                $this->appRoot,
                'Http',
                'Controllers',
                'Api',
                $apiController->getName()
            ])
        );
    }

    protected function saveApiFormRequest(CrudlySet $developedSet): bool
    {
        $apiFormRequest = $developedSet->getApiCrudFormRequest();

        return $apiFormRequest->save(
            $this->joinPathComponentsAndExtension([
                $this->appRoot,
                'Http',
                'Requests',
                'Api',
                $apiFormRequest->getName()
            ])
        );
    }

    protected function saveApiResource(CrudlySet $developedSet): bool
    {
        $apiResource = $developedSet->getApiCrudApiResource();

        return $apiResource->save(
            $this->joinPathComponentsAndExtension([
                $this->appRoot,
                'Http',
                'Resources',
                $apiResource->getName()
            ])
        );
    }

    protected function saveApiTests(CrudlySet $developedSet): bool
    {
        $apiTests = $developedSet->getApiTests();

        return $apiTests->save(
            $this->joinPathComponentsAndExtension([
                $this->projectRoot,
                'tests',
                'Feature',
                'Api',
                $apiTests->getName()
            ])
        );
    }

    protected function savePolicy(CrudlySet $developedSet): bool
    {
        $policy = $developedSet->getPolicy();

        return $policy->save(
            $this->joinPathComponentsAndExtension([
                $this->appRoot,
                'Policies',
                $policy->getName()
            ])
        );
    }

    protected function joinPathComponentsAndExtension(array $relativePathComponents): string
    {
        return implode(DIRECTORY_SEPARATOR, $relativePathComponents) . '.php';
    }

    protected function guessMigrationFilename(CrudlySet $developedSet): string
    {
        $tableName = Str::of($developedSet->getModel()->getName())->plural()->snake();
        $datePrefix = date('Y_m_d_His');

        return "{$datePrefix}_create_{$tableName}.php";
    }
}
