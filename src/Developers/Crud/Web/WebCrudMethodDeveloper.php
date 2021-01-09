<?php

namespace Shomisha\Crudly\Developers\Crud\Web;

use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

abstract class WebCrudMethodDeveloper extends CrudMethodDeveloper
{
    protected function hasAuthorization(CrudlySpecification $specification): bool
    {
        return $specification->hasWebAuthorization();
    }
}
