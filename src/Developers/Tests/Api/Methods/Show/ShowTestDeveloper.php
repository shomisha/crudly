<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Show;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class ShowTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "user_can_get_single_{$modelComponent}";
    }
}
