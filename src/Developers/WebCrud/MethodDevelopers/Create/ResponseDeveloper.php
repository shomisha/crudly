<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['create'];
    }

    /**
     * @param \Shomisha\Crudly\Contracts\Specification $specification
     * @param \Shomisha\Crudly\Data\CrudlySet $developedSet
     * @param \Shomisha\Crudly\Templates\Crud\CrudMethod $method
     */
    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
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

        $method->returnView(
            $this->guessModelViewNamespace($specification->getModel()) . '.create',
            array_merge([
                $modelVarName => Reference::variable($modelVarName)
            ], $relationships)
        );
    }
}
