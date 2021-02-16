<?php

namespace Shomisha\Crudly\Test\Specification;

use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

class PropertySpecificationBuilder
{
    private string $name;

    private ModelPropertyType $type;

    private bool $unsigned = false;
    private bool $autoIncrement = false;

    private bool $unique = false;
    private bool $nullable = false;

    private bool $primary = false;

    private bool $foreign = false;
    private ?string $foreignKeyField = null;
    private ?string $foreignTable = null;
    private ?ForeignKeyAction $onUpdate = null;
    private ?ForeignKeyAction $onDelete = null;

    private bool $hasRelationship = false;
    private ?string $relationshipName = null;

    private ?CrudlySpecificationBuilder $parent;


    public function __construct(string $name, ModelPropertyType $type, ?CrudlySpecificationBuilder $parent)
    {
        $this->name = $name;
        $this->type = $type;
        $this->parent = $parent;
    }

    public static function new(string $name, ModelPropertyType $type): self
    {
        return new self($name, $type, null);
    }

    public function unsigned(bool $unsigned = true): self
    {
        $this->unsigned = $unsigned;

        return $this;
    }

    public function autoIncrement(bool $autoIncrement = true): self
    {
        $this->autoIncrement = $autoIncrement;

        return $this;
    }

    public function unique(bool $unique = true): self
    {
        $this->unique = $unique;

        return $this;
    }

    public function nullable(bool $nullable = true): self
    {
        $this->nullable = $nullable;

        return $this;
    }

    public function primary(bool $primary = true): self
    {
        $this->primary = $primary;

        return $this;
    }

    public function isForeign(string $key, string $table, ?ForeignKeyAction $onUpdate = null, ?ForeignKeyAction $onDelete = null): self
    {
        $this->foreign = true;
        $this->foreignKeyField = $key;
        $this->foreignTable = $table;
        $this->onUpdate = $onUpdate ?? ForeignKeyAction::DO_NOTHING();
        $this->onDelete = $onDelete?? ForeignKeyAction::DO_NOTHING();

        return $this;
    }

    public function isNotForeign(): self
    {
        $this->foreign = false;
        $this->foreignKeyField = null;
        $this->foreignTable = null;
        $this->onUpdate = null;
        $this->onDelete = null;

        return $this;
    }

    public function isRelationship(string $name): self
    {
        $this->hasRelationship = true;
        $this->relationshipName = $name;

        return $this;
    }

    public function isNotRelationship(): self
    {
        $this->hasRelationship = false;
        $this->relationshipName = null;

        return $this;
    }

    public function buildSpecification(): ModelPropertySpecification
    {
        return new ModelPropertySpecification($this->buildArray());
    }

    public function buildArray(): array
    {
        $foreignKeyTarget = [];

        if ($this->foreign) {
            $foreignKeyTarget = [
                'table' => $this->foreignTable,
                'field' => $this->foreignKeyField,
                'has_relationship' => $this->hasRelationship,
                'relationship' => [
                    'name' => $this->relationshipName,
                ],
                'on_delete' => $this->onDelete,
                'on_update' => $this->onUpdate,
            ];
        }

        return [
            'name' => $this->name,
            'type' => $this->type,
            'is_autoincrement' => $this->autoIncrement,
            'is_unsigned' => $this->unsigned,
            'is_nullable' => $this->nullable,
            'is_unique' => $this->unique,
            'is_primary' => $this->primary,
            'is_foreign_key' => $this->foreign,
            'foreign_key_target' => $foreignKeyTarget,
        ];
    }

    public function __call($name, $arguments)
    {
        return $this->parent->{$name}(...$arguments);
    }
}
