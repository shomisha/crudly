<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\Utilities\Importable;

class ImplicitBindArgumentsDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['show'];
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    protected function performDevelopment(Specification $specification, CrudMethod $method)
    {
        $model = $specification->getModel();
        $modelArgName = $this->guessSingularModelVariableName($model->getName());

        $method->addArgument(
            Argument::name($modelArgName)->type(new Importable($model->getFullyQualifiedName()))
        );
    }
}
