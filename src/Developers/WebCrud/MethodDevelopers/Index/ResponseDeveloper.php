<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends MethodBodyDeveloper
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
        $model = $specification->getModel();
        $modelsVariable = $this->guessPluralModelVariableName($model->getName());

        $method->returnView(
            $this->guessModelViewNamespace($model) . '.index',
            [
                $modelsVariable => Reference::variable($modelsVariable)
            ]
        );
    }
}
