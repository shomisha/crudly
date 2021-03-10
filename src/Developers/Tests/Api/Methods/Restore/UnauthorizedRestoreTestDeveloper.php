<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Restore;

use Shomisha\Crudly\Developers\Tests\Api\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class UnauthorizedRestoreTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "unauthorized_user_cannot_restore_soft_deleted_{$modelComponent}";
    }
}
