<?php

namespace Shomisha\Crudly\Developers\Factory;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Data\ModelName;

abstract class FactoryDeveloper extends Developer
{
    protected function guessFactoryFullName(ModelName $model): string
    {
        // TODO: make this domain-aware using specification?
        return "Database\Factories\\" . $this->guessFactoryShortName($model);
    }

    protected function guessFactoryShortName(ModelName $model): string
    {
        $modelName = $model->getName();

        return "{$modelName}Factory";
    }

    protected function factoryExists(ModelName $model): bool
    {
        return class_exists($this->guessFactoryFullName($model));
    }
}
