<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\ForceDelete;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class ForceDeleteTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_force_delete_{$modelComponent}";
    }
}
