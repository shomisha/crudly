<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers;

use Shomisha\Crudly\Specifications\CrudlySpecification;

abstract class WebCrudMethodDeveloper extends CrudMethodDeveloper
{
    protected function hasAuthorization(CrudlySpecification $specification): bool
    {
        return $specification->hasWebAuthorization();
    }
}
