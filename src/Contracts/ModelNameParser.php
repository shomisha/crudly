<?php

namespace Shomisha\Crudly\Contracts;

use Shomisha\Crudly\Data\ModelName;

interface ModelNameParser
{
    public function parseModelName(string $rawName): ModelName;

    public function modelNameIsValid(string $rawName): bool;
}
