<?php

namespace Shomisha\Crudly\Test\Mocks;

use Shomisha\Crudly\Utilities\ModelSupervisor;

class ModelSupervisorMock extends ModelSupervisor
{
    private array $existingModels = [];

    public function __construct()
    {
        $this->setRootNamespace('App');
    }

    public function modelExists(string $rawName): bool
    {
        return in_array($rawName, $this->existingModels);
    }

    public function expectedExistingModels(array $models): self
    {
        $this->existingModels = $models;

        return $this;
    }

    public function shouldUseModelsDirectory(): bool
    {
        return true;
    }
}
