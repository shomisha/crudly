<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['show'];
    }

    /**
     * @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification
     * @param \Shomisha\Crudly\Templates\Crud\Web\WebCrudMethod $method
     */
    protected function performDevelopment(Specification $specification, CrudMethod $method)
    {
        $model = $specification->getModel();
        $modelVarName = $this->guessSingularModelVariableName($model->getName());

        $method->returnView(
            $this->guessModelViewNamespace($model) . '.show',
            [
                $modelVarName => Reference::variable($modelVarName)
            ]
        );
    }
}
