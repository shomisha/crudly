<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Edit;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        $modelName = $this->guessSingularModelVariableName($specification->getModel()->getName());
        $relationships = collect($this->extractForeignKeyTablesFromSpecification($specification))->mapWithKeys(function (string $relationshipTable) {
            $relationshipVariableName = $this->guessPluralModelVariableName(
                $this->getModelSupervisor()->parseModelNameFromTable($relationshipTable)
            );

            return [
                $relationshipVariableName => Reference::variable($relationshipVariableName),
            ];
        })->toArray();

        return $this->returnViewBlock(
            $this->guessModelViewNamespace($specification->getModel(), 'edit'),
            array_merge([
                $modelName => Reference::variable($modelName),
            ], $relationships)
        );
    }
}
