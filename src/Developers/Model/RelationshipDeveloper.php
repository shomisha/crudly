<?php

namespace Shomisha\Crudly\Developers\Model;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\RelationshipType;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class RelationshipDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        /** @var \Shomisha\Stubless\DeclarativeCode\ClassTemplate $model */
        $model = $developedSet->getModel();

        foreach ($this->getRelationshipMethods($specification) as $relationshipMethod) {
            $model->addMethod($relationshipMethod);
        }

        return $model;
    }

    /** @return \Shomisha\Stubless\DeclarativeCode\ClassMethod[] */
    private function getRelationshipMethods(CrudlySpecification $specification): array
    {
        $relationshipMethods = [];

        foreach ($specification->getProperties() as $modelPropertySpecification) {
            if ($modelPropertySpecification->isForeignKey() && $modelPropertySpecification->getForeignKeySpecification()->hasRelationship()) {
                $relationshipMethods[] = $this->convertPropertySpecificationToRelationshipMethod($modelPropertySpecification);
            }
        }

        return array_filter($relationshipMethods);
    }

    private function convertPropertySpecificationToRelationshipMethod(ModelPropertySpecification $specification): ?ClassMethod
    {
        $foreignKeySpecification = $specification->getForeignKeySpecification();

        $relationshipTargetTable = $foreignKeySpecification->getForeignKeyTable();
        $modelName = $this->getModelSupervisor()->parseModelNameFromTable($relationshipTargetTable);

        if (!$this->getModelSupervisor()->modelExists($modelName->getName())) {
            return null;
        }

        return $this->prepareRelationshipMethod(
            $foreignKeySpecification->getRelationshipType(),
            $modelName,
            $foreignKeySpecification->getRelationshipName(),
            $specification->getName(),
            $foreignKeySpecification->getForeignKeyField(),
        );
    }

    private function prepareRelationshipMethod(RelationshipType $type, ModelName $model, string $relationshipName, string $foreignKeyField, string $localKeyField): ClassMethod
    {
        $method = ClassMethod::name($relationshipName);

        $method->body(
            Block::return(
                Block::invokeMethod(
                    Reference::this(),
                    $type->value(),
                    [
                        Reference::classReference(
                            $model->getName()
                        ),
                        $foreignKeyField,
                        $localKeyField,
                    ]
                )
            )
        );

        return $method;
    }
}
