<?php

namespace Shomisha\Crudly\Developers\Tests;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;

abstract class TestsDeveloper extends Developer
{
    protected function guessTestClassName(ModelName $model): string
    {
        return Str::of($model->getName())->plural();
    }
}
