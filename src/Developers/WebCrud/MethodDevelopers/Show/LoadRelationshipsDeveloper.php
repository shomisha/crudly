<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class LoadRelationshipsDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['show'];
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    protected function performDevelopment(Specification $specification, CrudMethod $method)
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel()->getName());

        $method->withMainBlock(
            Block::invokeMethod(
                Reference::variable($modelVarName),
                'load',
                [
                    $this->getRelationships($specification)
                ]
            )
        );
    }

    protected function getRelationships(CrudlySpecification $specification): array
    {
        return $specification->getProperties()->map(function (ModelPropertySpecification $modelSpecification) {
            if (!$modelSpecification->isForeignKey()) {
                return null;
            }

            return $modelSpecification->getForeignKeySpecification()->getRelationshipName();
        })->filter()->values()->toArray();
    }
}
