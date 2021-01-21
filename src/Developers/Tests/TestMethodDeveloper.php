<?php

namespace Shomisha\Crudly\Developers\Tests;

use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Developer as DeveloperContract;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Stubless\TestMethod;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager getManager() */
abstract class TestMethodDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $testMethod = TestMethod::name($this->getName($specification))->withDataProvider(
            $this->getDataProvider($specification, $developedSet)
        );

        $testMethod->setBody(Block::fromArray([
            $this->getArrangeDeveloper()->develop($specification, $developedSet),
            $this->getActDeveloper()->develop($specification, $developedSet),
            $this->getAssertDeveloper()->develop($specification, $developedSet),
        ]));

        return $testMethod;
    }

    abstract protected function getName(CrudlySpecification $specification): string;

    protected function getDataProvider(CrudlySpecification $specification, CrudlySet $developedSet): ?string
    {
        return null;
    }

    protected function getArrangeDeveloper(): DeveloperContract
    {
        return $this->getManager()->getArrangeDeveloper();
    }

    protected function getActDeveloper(): DeveloperContract
    {
        return $this->getManager()->getActDeveloper();
    }

    protected function getAssertDeveloper(): DeveloperContract
    {
        return $this->getManager()->getAssertDeveloper();
    }

    protected function getPluralModelNameComponent(ModelName $model): string
    {
        return Str::of($model->getName())->plural()->snake();
    }

    protected function getSingularModelNameComponent(ModelName $modelName): string
    {
        return Str::of($modelName->getName())->singular()->snake();
    }
}
