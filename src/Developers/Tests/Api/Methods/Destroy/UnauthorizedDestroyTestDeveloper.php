<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Destroy;

use Shomisha\Crudly\Developers\Tests\Api\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedDestroyTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_user_cannot_delete_{$modelComponent}";
    }
}
