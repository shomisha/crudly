<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Update;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UpdateTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_update_{$modelComponent}";
    }
}
