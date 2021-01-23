<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Show;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class ShowTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelName = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "user_can_access_the_single_{$modelName}_page";
    }
}
