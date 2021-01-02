<?php

namespace Shomisha\Crudly\Contracts;

use Shomisha\Crudly\Data\ModelName;

interface ModelSupervisor
{
    public function parseModelName(string $rawName): ModelName;

    public function modelNameIsValid(string $rawName): bool;

    public function modelExists(string $rawName): bool;

    public function shouldUseModelsDirectory(): bool;
}
