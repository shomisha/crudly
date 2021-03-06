<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Destroy;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class DestroyTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_delete_{$modelComponent}";
    }
}
