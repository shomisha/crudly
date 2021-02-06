<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel());

        $relationships = collect($this->extractRelationshipTablesFromSpecification($specification))->mapWithKeys(function (string $relationshipTable) {
            $relationshipVariableName = $this->guessPluralModelVariableName(
                $this->getModelSupervisor()->parseModelNameFromTable($relationshipTable)
            );

            return [
                $relationshipVariableName => Reference::variable($relationshipVariableName),
            ];
        })->toArray();

        return $this->returnViewBlock(
            $this->guessModelViewNamespace($specification->getModel(), 'create'),
            array_merge([
                $modelVarName => Reference::variable($modelVarName)
            ], $relationships)
        );
    }
}
