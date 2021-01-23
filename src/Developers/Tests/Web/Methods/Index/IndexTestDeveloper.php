<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Index;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class IndexTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelNameComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "users_can_access_the_{$modelNameComponent}_index_page";
    }
}
