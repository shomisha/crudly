<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\ForceDelete;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedForceDeleteTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_user_cannot_force_delete_{$modelComponent}";
    }
}
