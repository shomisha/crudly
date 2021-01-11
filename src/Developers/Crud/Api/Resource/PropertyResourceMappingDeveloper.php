<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Resource;

use Illuminate\Support\Collection;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;
use Shomisha\Stubless\Values\Value;

class PropertyResourceMappingDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $primary = $specification->getPrimaryKey();
        $remainingFields = $specification->getProperties()->except($primary->getName());

        $mappings = collect([$primary])->concat($remainingFields)->mapWithKeys(function (ModelPropertySpecification $property) {
            return [
                $this->guessPropertyMappingKey($property) => $this->preparePropertyResourceMapping($property),
            ];
        });

        if ($specification->hasTimestamps()) {
            $this->addTimestampMappings($mappings);
        }

        return Value::array($mappings->toArray());
    }

    protected function guessPropertyMappingKey(ModelPropertySpecification $property): string
    {
        if (!$this->propertyIsRelationship($property)) {
            return $property->getName();
        }

        $foreignKey = $property->getForeignKeySpecification();

        $relationshipModelName = $this->getModelSupervisor()->parseModelNameFromTable($foreignKey->getForeignKeyTable());
        if (!$this->getModelSupervisor()->modelExists($relationshipModelName->getName())) {
            return $property->getName();
        }

        return $foreignKey->getRelationshipName();
    }

    protected function preparePropertyResourceMapping(ModelPropertySpecification $property): Code
    {
        if ($this->propertyIsRelationship($property)) {
            $relationshipTableName = $property->getForeignKeySpecification()->getForeignKeyTable();
            $relationshipName = $property->getForeignKeySpecification()->getRelationshipName();
            $relationshipModel = $this->getModelSupervisor()->parseModelNameFromTable($relationshipTableName);

            if ($this->getModelSupervisor()->modelExists($relationshipModel->getName())) {
                return Block::instantiate(
                    new Importable($this->guessApiResourceClass($relationshipModel)),
                    [
                        Block::invokeMethod(
                            Reference::this(),
                            'whenLoaded',
                            [$relationshipName]
                        )
                    ]
                );
            }
        }

        $propertyName = $property->getName();
        return Reference::objectProperty(Reference::this(), $propertyName);
    }

    protected function addTimestampMappings(Collection $mappings): Collection
    {
        return $mappings->put(
            'updated_at',
            Reference::objectProperty(
                Reference::this(),
                'updated_at'
            ),
        )->put(
            'created_at',
            Reference::objectProperty(
                Reference::this(),
                'created_at'
            )
        );
    }
}
