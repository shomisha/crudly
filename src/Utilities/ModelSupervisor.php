<?php

namespace Shomisha\Crudly\Utilities;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Shomisha\Crudly\Contracts\ModelSupervisor as ModelSupervisorContract;
use Shomisha\Crudly\Data\ModelName;

class ModelSupervisor implements ModelSupervisorContract
{
    private Filesystem $filesystem;

    private string $appPath;

    // TODO: pull this from the container
    private string $rootNamespace = 'App';

    public function __construct(Filesystem $filesystem, string $appPath)
    {
        $this->filesystem = $filesystem;
        $this->appPath = $appPath;
    }

    public function parseModelName(string $rawName): ModelName
    {
        if (!$this->modelNameIsValid($rawName)) {
            throw new \InvalidArgumentException("'{$rawName}' is not a valid model name.");
        }

        $pieces = explode('\\', $rawName);

        $className = ucfirst(array_pop($pieces));
        $classNamespace = null;
        if (!empty($pieces)) {
            $classNamespace = implode('\\', $pieces);
        }

        return new ModelName($className, $this->rootNamespace, $classNamespace);
    }

    public function parseModelNameFromTable(string $tableName): ModelName
    {
        return $this->parseModelName(
            Str::of($tableName)->studly()->singular()
        );
    }

    public function modelNameIsValid(string $rawName): bool
    {
        $pattern = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\\\\]*[a-zA-Z0-9_\x7f-\xff]$/';

        return preg_match($pattern, $rawName);
    }

    public function modelExists(string $rawName): bool
    {
        $modelName = $this->parseModelName($rawName);

        return $this->filesystem->exists(
            $this->guessModelPath($modelName)
        );
    }

    public function shouldUseModelsDirectory(): bool
    {
        $modelsDirectoryPath = $this->appPath . DIRECTORY_SEPARATOR . "Models";

        return $this->filesystem->isDirectory($modelsDirectoryPath);
    }

    private function guessModelPath(ModelName $name): string
    {
        if ($this->shouldUseModelsDirectory()) {
            $this->appPath .= DIRECTORY_SEPARATOR . "Models";
        }

        return $this->appPath . DIRECTORY_SEPARATOR .  $name->getName() . '.php';
    }
}
