<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\NewDefaults;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertDatabaseContainsNewModel extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::this(),
            'assertDatabaseHas',
            [
                $this->guessTableName($specification->getModel()),
                $this->guessDefaults($specification),
            ]
        );
    }

    protected function guessDefaults(CrudlySpecification $specification): array
    {
        $defaults = NewDefaults::new();

        return $specification->getProperties()->mapWithKeys(function (ModelPropertySpecification $property) use ($defaults) {
            if (!$defaults->canGuessDefaultFor($property)) {
                return [null => null];
            }

            return [
                $property->getName() => $defaults->guessDefaultFor($property),
            ];
        })->filter()->toArray();
    }
}
