<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
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
            $this->guessModelViewNamespace($specification->getModel()) . '.create',
            array_merge([
                $modelVarName => Reference::variable($modelVarName)
            ], $relationships)
        );
    }
}
