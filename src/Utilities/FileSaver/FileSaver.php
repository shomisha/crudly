<?php

namespace Shomisha\Crudly\Utilities\FileSaver;

use Illuminate\Support\Str;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Utilities\ModelSupervisor;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

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

        if ($developedSet->getPolicy()) {
            $this->savePolicy($developedSet);
        }
    }

    protected function saveMigration(CrudlySet $developedSet): bool
    {
        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->projectRoot,
                'database',
                'migrations',
                $this->guessMigrationFilename($developedSet),
            ],
             $developedSet->getMigration()
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

        return $this->saveToPotentiallyMissingDirectory(
            $components,
            $model
        );
    }

    protected function saveFactory(CrudlySet $developedSet): bool
    {
        $factory = $developedSet->getFactory();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->projectRoot,
                'database',
                'factories',
                $factory->getName(),
            ],
            $factory
        );
    }

    protected function saveWebController(CrudlySet $developedSet): bool
    {
        $controller = $developedSet->getWebCrudController();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->appRoot,
                'Http',
                'Controllers',
                'Web',
                $controller->getName(),
            ],
            $controller
        );
    }

    protected function saveWebFormRequest(CrudlySet $developedSet): bool
    {
        $formRequest = $developedSet->getWebCrudFormRequest();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->appRoot,
                'Http',
                'Requests',
                'Web',
                $formRequest->getName(),
            ],
            $formRequest
        );
    }

    protected function saveWebTests(CrudlySet $developedSet): bool
    {
        $webTests = $developedSet->getWebTests();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->projectRoot,
                'tests',
                'Feature',
                'Web',
                $webTests->getName()
            ],
            $webTests
        );
    }

    protected function saveApiController(CrudlySet $developedSet): bool
    {
        $apiController = $developedSet->getApiCrudController();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->appRoot,
                'Http',
                'Controllers',
                'Api',
                $apiController->getName()
            ],
            $apiController
        );
    }

    protected function saveApiFormRequest(CrudlySet $developedSet): bool
    {
        $apiFormRequest = $developedSet->getApiCrudFormRequest();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->appRoot,
                'Http',
                'Requests',
                'Api',
                $apiFormRequest->getName()
            ],
            $apiFormRequest
        );
    }

    protected function saveApiResource(CrudlySet $developedSet): bool
    {
        $apiResource = $developedSet->getApiCrudApiResource();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->appRoot,
                'Http',
                'Resources',
                $apiResource->getName()
            ],
            $apiResource
        );
    }

    protected function saveApiTests(CrudlySet $developedSet): bool
    {
        $apiTests = $developedSet->getApiTests();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->projectRoot,
                'tests',
                'Feature',
                'Api',
                $apiTests->getName()
            ],
            $apiTests
        );
    }

    protected function savePolicy(CrudlySet $developedSet): bool
    {
        $policy = $developedSet->getPolicy();

        return $this->saveToPotentiallyMissingDirectory(
            [
                $this->appRoot,
                'Policies',
                $policy->getName()
            ],
            $policy
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

        return "{$datePrefix}_create_{$tableName}_table";
    }

    protected function saveToPotentiallyMissingDirectory(array $pathComponents, ClassTemplate $class): bool
    {
        $path = $this->joinPathComponentsAndExtension($pathComponents);
        $isInFolder = preg_match("/^(.*)\/([^\/]+)$/", $path, $filepathMatches);

        if($isInFolder) {
            $folderName = $filepathMatches[1];
            if (!is_dir($folderName)) {
                mkdir($folderName, 0777, true);
            }
        }

        return $class->save($path);
    }
}
