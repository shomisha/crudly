<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Index;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedIndexTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_user_cannot_get_the_{$modelComponent}_list";
    }
}
