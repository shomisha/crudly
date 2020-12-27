<?php

namespace Shomisha\Crudly;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Shomisha\Crudly\Contracts\ModelNameParser;
use Shomisha\Crudly\Data\ModelName;

class Crudly
{
    private ModelNameParser $modelNameParser;

    private Container $app;

    private Filesystem $filesystem;

    public function __construct(Container $app, ModelNameParser $modelNameParser)
    {
        $this->app = $app;
        $this->filesystem = $this->app['files'];
        $this->modelNameParser = $modelNameParser;
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

    private function guessModelPath(ModelName $name): string
    {
        $appPath = $this->app['path'];

        if ($this->shouldUseModelsDirectory()) {
            $appPath .= DIRECTORY_SEPARATOR . "Models";
        }

        return $appPath . DIRECTORY_SEPARATOR .  $name->getName() . '.php';
    }

    private function shouldUseModelsDirectory(): bool
    {
        $modelsDirectoryPath = $this->app['path'] . DIRECTORY_SEPARATOR . "Models";

        return $this->filesystem->isDirectory($modelsDirectoryPath);
    }
}
