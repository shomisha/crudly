<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Create;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class CreateTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "user_can_access_the_create_new_{$modelComponent}_page";
    }
}
