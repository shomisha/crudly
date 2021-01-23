<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Create;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedCreateTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "unauthorized_user_cannot_visit_the_create_new_{$modelComponent}_page";
    }
}
