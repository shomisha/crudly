<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Destroy;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedDestroyTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_user_cannot_delete_{$modelComponent}";
    }
}
