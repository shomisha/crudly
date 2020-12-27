<?php

namespace Shomisha\Crudly\Utilities;

use Shomisha\Crudly\Contracts\ModelNameParser as ModelNameParserContract;
use Shomisha\Crudly\Data\ModelName;

class ModelNameParser implements ModelNameParserContract
{
    public function parseModelName(string $rawName): ModelName
    {
        if (!$this->modelNameIsValid($rawName)) {
            throw new \InvalidArgumentException("'{$rawName}' is not a valid model name.");
        }

        $pieces = explode('\\', $rawName);

        $className = array_pop($pieces);
        $classNamespace = null;
        if (!empty($pieces)) {
            $classNamespace = implode('\\', $pieces);
        }

        return new ModelName($className, $classNamespace);
    }

    public function modelNameIsValid(string $rawName): bool
    {
        $pattern = '/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff\\\\]*[a-zA-Z0-9_\x7f-\xff]$/';

        return preg_match($pattern, $rawName);
    }
}
