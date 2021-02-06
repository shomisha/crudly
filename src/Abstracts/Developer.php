<?php

namespace Shomisha\Crudly\Abstracts;

use Illuminate\Support\Str;
use Shomisha\Crudly\Contracts\Developer as DeveloperContract;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

abstract class Developer implements DeveloperContract
{
    private DeveloperManagerAbstract $manager;

    private ModelSupervisor $modelSupervisor;

    private array $parameters = [];

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor)
    {
        $this->manager = $manager;
        $this->modelSupervisor = $modelSupervisor;
    }

    public function using(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    protected function getParameter(string $name)
    {
        return $this->parameters[$name];
    }

    protected function parameterOrDefault(string $name, $default)
    {
        if (!$this->hasParameter($name)) {
            return $default;
        }

        return $this->getParameter($name);
    }

    protected function hasParameter(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    protected function getManager(): DeveloperManagerAbstract
    {
        return $this->manager;
    }

    protected function getModelSupervisor(): ModelSupervisor
    {
        return $this->modelSupervisor;
    }

    protected function propertyIsRelationship(ModelPropertySpecification $property): bool
    {
        return $property->isForeignKey() && $property->getForeignKeySpecification()->hasRelationship();
    }

    protected function guessTableName(ModelName $modelName): string
    {
        return Str::of($modelName->getName())->plural()->snake();
    }

    protected function guessSingularModelVariableName(string $modelName): string
    {
        return Str::of($modelName)->camel();
    }

    protected function guessPluralModelVariableName(string $modelName): string
    {
        return Str::of($modelName)->camel()->plural();
    }

    protected function guessModelViewNamespace(ModelName $modelName, ?string $viewName = null): string
    {
        $name = '';

        if ($namespace = $modelName->getNamespace()) {
            $name .= Str::of($namespace)->replace('\\', '.')->snake()->singular() . ".";
        }

        $name .= Str::of($modelName->getName())->snake()->plural();

        if ($viewName !== null) {
            $name .= ".{$viewName}";
        }

        return $name;
    }
}
