<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class AuthorizationDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['index'];
    }

    /**
     * @param \Shomisha\Crudly\Contracts\Specification $specification
     * @param \Shomisha\Crudly\Data\CrudlySet $developedSet
     * @param \Shomisha\Crudly\Templates\Crud\CrudMethod $method
     */
    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
    {
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        $method->withAuthorization(
            Block::invokeMethod(
                Reference::this(),
                'authorize',
                [
                    'viewAll',
                    Reference::classReference(new Importable($fullModelName))
                ]
            )
        );
    }
}
