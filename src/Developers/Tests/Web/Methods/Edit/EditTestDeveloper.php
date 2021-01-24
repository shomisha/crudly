<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Edit;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class EditTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "user_can_access_the_edit_{$modelComponent}_page";
    }
}
