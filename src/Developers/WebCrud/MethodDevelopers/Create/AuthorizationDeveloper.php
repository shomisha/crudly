<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

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
        return $developedSet->getWebCrudController()->getMethods()['create'];
    }

    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
    {
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        $method->withAuthorization(
            Block::invokeMethod(
                Reference::this(),
                'authorize',
                [
                    'create',
                    Reference::classReference(new Importable($fullModelName))
                ]
            )
        );
    }
}
