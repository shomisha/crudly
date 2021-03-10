<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Store;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedStoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_users_cannot_crete_new_{$modelComponent}";
    }
}
