<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Show;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedShowTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "unauthorized_user_cannot_access_the_{$modelComponent}_single_page";
    }
}
