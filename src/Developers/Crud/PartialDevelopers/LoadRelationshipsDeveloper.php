<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Abstractions\ImperativeCode;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class LoadRelationshipsDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ImperativeCode
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel()->getName());

        $relationships = $this->extractRelationshipsFromSpecification($specification);

        if (empty($relationships)) {
            return Block::fromArray([]);
        }

        return Block::invokeMethod(
            Reference::variable($modelVarName),
            'load',
            [$relationships]
        );
    }

    protected function extractRelationshipsFromSpecification(CrudlySpecification $specification): array
    {
        return $specification->getProperties()->map(function (ModelPropertySpecification $propertySpecification) {
            if (!$this->propertyIsRelationship($propertySpecification)) {
                return null;
            }

            $relationshipModelName = $this->getModelSupervisor()->parseModelNameFromTable($propertySpecification->getForeignKeySpecification()->getForeignKeyTable());
            if (!$this->getModelSupervisor()->modelExists($relationshipModelName->getName())) {
                return null;
            }

            return $propertySpecification->getForeignKeySpecification()->getRelationshipName();
        })->filter()->values()->toArray();
    }


}
