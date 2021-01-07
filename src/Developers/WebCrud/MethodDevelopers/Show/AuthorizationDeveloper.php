<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AuthorizationDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['show'];
    }

    /**
     * @param \Shomisha\Crudly\Contracts\Specification $specification
     * @param \Shomisha\Crudly\Data\CrudlySet $developedSet
     * @param \Shomisha\Crudly\Templates\Crud\CrudMethod $method
     */
    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel()->getName());

        $method->withAuthorization(
            Block::invokeMethod(
                Reference::this(),
                'authorize',
                [
                    'view',
                    Reference::variable($modelVarName)
                ]
            )
        );
    }
}
