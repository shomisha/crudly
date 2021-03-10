<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Store;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class StoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_create_new_{$modelComponent}";
    }
}
