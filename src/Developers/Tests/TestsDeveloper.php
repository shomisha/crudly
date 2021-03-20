<?php

namespace Shomisha\Crudly\Developers\Tests;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Exceptions\IncompleteTestException;

/**
 * Class TestsDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager getManager()
 */
abstract class TestsDeveloper extends Developer
{
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
        return IncompleteTestException::class;
    }

    protected function guessUserClass(): ModelName
    {
        return $this->getModelSupervisor()->parseModelName('user');
    }

    protected function getModelDataMethodName(ModelName $model): string
    {
        $modelComponent = ucfirst($this->guessSingularModelVariableName($model));

        return "get{$modelComponent}Data";
    }

    protected function guessInvalidDataProviderName(ModelName $model): string
    {
        $modelComponent = ucfirst($this->guessSingularModelVariableName($model));

        return "invalid{$modelComponent}DataProvider";
    }
}
