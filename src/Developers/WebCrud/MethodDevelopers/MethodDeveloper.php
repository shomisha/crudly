<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;

abstract class MethodDeveloper extends Developer
{
    protected function guessSingularModelVariableName(string $modelName): string
    {
        return Str::of($modelName)->camel();
    }

    protected function guessPluralModelVariableName(string $modelName): string
    {
        return Str::of($modelName)->camel()->plural();
    }

    protected function guessModelViewNamespace(ModelName $modelName): string
    {
        $name = '';

        if ($namespace = $modelName->getNamespace()) {
            $name .= Str::of($namespace)->replace('\\', '.')->snake()->singular() . ".";
        }

        $name .= Str::of($modelName->getName())->snake()->singular();

        return $name;
    }
}
