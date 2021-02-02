<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Store;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedStoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_user_cannot_create_new_{$modelComponent}";
    }
}
