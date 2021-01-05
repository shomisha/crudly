<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

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

    protected function extractRelationshipsFromSpecification(CrudlySpecification $specification): array
    {
        return $specification->getProperties()->map(function (ModelPropertySpecification $modelSpecification) {
            if (!$modelSpecification->isForeignKey()) {
                return null;
            }

            return $modelSpecification->getForeignKeySpecification()->getRelationshipName();
        })->filter()->values()->toArray();
    }

    protected function extractRelationshipTablesFromSpecification(CrudlySpecification $specification): array
    {
        return $specification->getProperties()->map(function (ModelPropertySpecification $propertySpecification) {
            if (!$propertySpecification->isForeignKey() || !$propertySpecification->getForeignKeySpecification()->hasRelationship()) {
                return;
            }

            return $propertySpecification->getForeignKeySpecification()->getForeignKeyTable();
        })->filter()->toArray();
    }
}
