<?php

namespace Shomisha\Crudly\Data;

class ModelName
{
    private string $name;

    private ?string $namespace;

    public function __construct(string $name, ?string $namespace)
    {
        $this->name = $name;
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
}
