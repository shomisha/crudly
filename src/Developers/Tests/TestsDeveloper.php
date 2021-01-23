<?php

namespace Shomisha\Crudly\Developers\Tests;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Exceptions\IncompleteWebTest;

abstract class TestsDeveloper extends Developer
{
    protected function guessTestClassFullName(ModelName $model): string
    {
        return $this->guessTestNamespace() . $this->guessTestClassShortName($model);
    }

    protected function guessTestClassShortName(ModelName $model): string
    {
        return Str::of($model->getName())->singular() . "Test";
    }

    protected function guessTestNamespace(): string
    {
        return "Tests\Feature\Web";
    }

    protected function guessTestNameSingularModelComponent(ModelName $model): string
    {
        return Str::of($model->getName())->singular()->snake('_');
    }

    protected function guessTestNamePluralModelComponent(ModelName $model): string
    {
        return Str::of($model->getName())->plural()->snake('_');
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
