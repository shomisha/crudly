<?php

namespace Shomisha\Crudly;

use Illuminate\Filesystem\Filesystem;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Developers\CrudlyDeveloper;
use Shomisha\Crudly\Managers\DeveloperManager;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Utilities\FileSaver\FileSaver;

class Crudly
{
    private ModelSupervisor $modelSupervisor;

    private DeveloperManager $developerManager;

    private FileSaver $fileSaver;

    public function __construct(ModelSupervisor $modelSupervisor, DeveloperManager $developerManager, FileSaver $fileSaver)
    {
        $this->modelSupervisor = $modelSupervisor;
        $this->developerManager = $developerManager;
        $this->fileSaver = $fileSaver;
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
        $developedSet = $this->getCrudlyDeveloper()->develop($specification);

        $this->fileSaver->saveAllFiles($developedSet);

        return $developedSet;
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
