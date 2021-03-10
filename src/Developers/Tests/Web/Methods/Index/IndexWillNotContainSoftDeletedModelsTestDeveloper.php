<?php

namespace Shomisha\Crudly\Developers\Tests\Web\Methods\Index;

use Shomisha\Crudly\Developers\Tests\Web\TestMethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class IndexWillNotContainSoftDeletedModelsTestDeveloper extends TestMethodDeveloper
{
    protected function getName(CrudlySpecification $specification): string
    {
        $modelComponent = $this->guessTestNamePluralModelComponent($specification->getModel());

        return "index_page_will_not_contain_soft_deleted_{$modelComponent}";
    }
}
