<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Restore;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class RestoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_restore_soft_deleted_{$modelComponent}";
    }
}
