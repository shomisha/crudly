<?php

namespace Shomisha\Crudly\Developers\Tests;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Exceptions\IncompleteWebTest;

abstract class TestsDeveloper extends Developer
{
    protected function guessTestClassName(ModelName $model): string
    {
        return Str::of($model->getName())->plural();
    }

    protected function incompleteWebTestExceptionName(): string
    {
        return IncompleteWebTest::class;
    }

    protected function guessUserClass(): ModelName
    {
        return $this->getModelSupervisor()->parseModelName('user');
    }
}
