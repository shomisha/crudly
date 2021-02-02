<?php

namespace Shomisha\Crudly\Developers\Tests\Api\Methods\Index;

use Shomisha\Crudly\Developers\Tests\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class IndexTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "user_can_get_a_list_of_{$modelComponent}";
    }
}
