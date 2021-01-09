<?php

namespace Shomisha\Crudly\Developers\Crud\Api;

use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

abstract class ApiCrudMethodDeveloper extends CrudMethodDeveloper
{
    protected function hasAuthorization(CrudlySpecification $specification): bool
    {
        return $specification->hasApiAuthorization();
    }
}
