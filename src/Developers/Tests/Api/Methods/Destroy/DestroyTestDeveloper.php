<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Destroy;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class DestroyTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_delete_{$modelComponent}";
    }
}
