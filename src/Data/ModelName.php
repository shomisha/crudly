<?php

namespace Shomisha\Crudly\Data;

class ModelName
{
    private string $name;

    private string $rootNamespace;

    private ?string $namespace;

    public function __construct(string $name, string $rootNamespace, ?string $namespace)
    {
        $this->name = $name;
        $this->rootNamespace = $rootNamespace;
        $this->namespace = $namespace;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function getFullNamespace(): string
    {
        $namespace = $this->rootNamespace;

        if ($this->namespace) {
            $namespace .= "\\{$this->namespace}}";
        }

        return $namespace;
    }

    public function getFullyQualifiedName(): string
    {
        return $this->getFullNamespace() . '\\' . $this->name;
    }
}
