<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\Views;

use Shomisha\Crudly\Data\ModelName;

class AssertViewIsEdit extends AssertViewIsDeveloper
{
    protected function getExpectedView(ModelName $model): string
    {
        return $this->guessModelViewNamespace($model) . '.edit';
    }
}
