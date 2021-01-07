<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;

class ResponseDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['store'];
    }

    /**
     * @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification
     * @param \Shomisha\Crudly\Templates\Crud\Web\WebCrudMethod $method
     */
    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
    {
        $method->returnRouteRedirect(
            $this->guessPluralModelVariableName($specification->getModel()->getName()) . '.index',
            ['success', "Successfully created new instance."]
        );
    }
}
