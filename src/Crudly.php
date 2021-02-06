<?php

namespace Shomisha\Crudly;

use Illuminate\Filesystem\Filesystem;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Developers\CrudlyDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Managers\DeveloperManager;

class Crudly
{
    private ModelSupervisor $modelSupervisor;

    private DeveloperManager $developerManager;

    private Filesystem $filesystem;

    private string $appPath;

    public function __construct(Filesystem $filesystem, ModelSupervisor $modelSupervisor, DeveloperManager $developerManager, string $appPath)
    {
        $this->modelSupervisor = $modelSupervisor;
        $this->developerManager = $developerManager;
        $this->filesystem = $filesystem;
        $this->appPath = $appPath;
    }

    public function parseModelName(string $modelName): ModelName
    {
        return $this->modelSupervisor->parseModelName($modelName);
    }

    public function modelNameIsValid(string $name): bool
    {
        return $this->modelSupervisor->modelNameIsValid($name);
    }

    public function modelExists(string $modelName): bool
    {
        return $this->modelSupervisor->modelExists($modelName);
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

    protected function setModelSupervisor(ModelSupervisor $modelSupervisor): self
    {
        $this->modelSupervisor = $modelSupervisor;

        return $this;
    }

    private function getCrudlyDeveloper(): CrudlyDeveloper
    {
        return new CrudlyDeveloper($this->developerManager);
    }
}
