<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Restore;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedRestoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNameSingularModelComponent($specification->getModel());

        return "unauthorized_user_cannot_restore_soft_deleted_{$modelComponent}";
    }
}
