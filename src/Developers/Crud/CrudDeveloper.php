<?php

namespace Shomisha\Crudly\Developers\Crud;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

abstract class CrudDeveloper extends Developer
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
        return $specification->getProperties()->map(function (ModelPropertySpecification $propertySpecification) {
            if (!$this->propertyIsRelationship($propertySpecification)) {
                return null;
            }

            return $propertySpecification->getForeignKeySpecification()->getRelationshipName();
        })->filter()->values()->toArray();
    }

    protected function extractRelationshipTablesFromSpecification(CrudlySpecification $specification): array
    {
        return $specification->getProperties()->map(function (ModelPropertySpecification $propertySpecification) {
            if (!$this->propertyIsRelationship($propertySpecification)) {
                return;
            }

            return $propertySpecification->getForeignKeySpecification()->getForeignKeyTable();
        })->filter()->toArray();
    }

    protected function guessFormRequestClass(ModelName $model): string
    {
        $classShortName = $this->guessFormRequestClassShortName($model);

        return "App\Http\Requests\\{$classShortName}Request";
    }

    protected function guessFormRequestClassShortName(ModelName $model): string
    {
        $modelName = $model->getName();

        return "{$modelName}Request";
    }

    protected function guessApiResourceClass(ModelName $modelName): string
    {
        $modelName = $modelName->getName();

        return "App\Http\Resources\\{$modelName}Resource";
    }

    protected function returnViewBlock(string $viewName, array $data = []): ReturnBlock
    {
        $viewResponse = Block::invokeFunction('view', array_filter([
            $viewName,
            $data,
        ]));

        return Block::return($viewResponse);
    }

    protected function returnRedirectRouteBlock(string $route, array $with = []): ReturnBlock
    {
        $redirectResponse = Block::invokeFunction('redirect')->chain('route', [$route]);

        if (!empty($with)) {
            $redirectResponse->chain('with', $with);
        }

        return Block::return($redirectResponse);
    }
}