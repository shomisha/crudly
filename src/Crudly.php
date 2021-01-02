<?php

namespace Shomisha\Crudly;

use Illuminate\Filesystem\Filesystem;
use Shomisha\Crudly\Contracts\ModelNameParser;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Developers\CrudlyDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Managers\DeveloperManager;

class Crudly
{
    private ModelNameParser $modelNameParser;

    private DeveloperManager $developerManager;

    private Filesystem $filesystem;

    private string $appPath;

    public function __construct(Filesystem $filesystem, ModelNameParser $modelNameParser, DeveloperManager $developerManager, string $appPath)
    {
        $this->modelNameParser = $modelNameParser;
        $this->developerManager = $developerManager;
        $this->filesystem = $filesystem;
        $this->appPath = $appPath;
    }

    public function parseModelName(string $modelName): ModelName
    {
        return $this->modelNameParser->parseModelName($modelName);
    }

    public function modelNameIsValid(string $name): bool
    {
        return $this->modelNameParser->modelNameIsValid($name);
    }

    public function modelExists(string $modelName): bool
    {
        $modelName = $this->modelNameParser->parseModelName($modelName);

        return $this->filesystem->exists(
            $this->guessModelPath($modelName)
        );
    }

    public function prepareSpecification(array $data): CrudlySpecification
    {
        $specification = new CrudlySpecification(
            $this->parseModelName($data['model']),
            $data
        );

        return $specification;
    }

    public function develop(CrudlySpecification $specification): CrudlySet
    {
        $set = $this->getCrudlyDeveloper()->develop($specification);

        return $set;
    }

    private function guessModelPath(ModelName $name): string
    {
        if ($this->shouldUseModelsDirectory()) {
            $this->appPath .= DIRECTORY_SEPARATOR . "Models";
        }

        return $this->appPath . DIRECTORY_SEPARATOR .  $name->getName() . '.php';
    }

    private function shouldUseModelsDirectory(): bool
    {
        $modelsDirectoryPath = $this->appPath . DIRECTORY_SEPARATOR . "Models";

        return $this->filesystem->isDirectory($modelsDirectoryPath);
    }

    private function getCrudlyDeveloper(): CrudlyDeveloper
    {
        return new CrudlyDeveloper($this->developerManager);
    }
}
