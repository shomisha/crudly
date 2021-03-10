<?php

namespace Shomisha\Crudly\Developers\Tests\Web;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper as BaseTestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

abstract class TestMethodDeveloper extends BaseTestMethodDeveloper
{
    protected function hasAuthorization(CrudlySpecification $specification): bool
    {
        return $specification->hasWebAuthorization();
    }
}
