<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\NewDefaults;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AssertModelUpdatedWithNewValuesDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $assertions = Block::fromArray([]);
        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($specification->getModel())
        );

        foreach ($this->getUpdatedFields($specification) as $fieldName => $newValue) {
            $assertions->addCode(
                Block::invokeMethod(
                    Reference::this(),
                    'assertEquals',
                    [
                        $newValue,
                        Reference::objectProperty($modelVar, $fieldName)
                    ]
                )
            );
        }

        return $assertions;
    }

    protected function getUpdatedFields(CrudlySpecification $specification): array
    {
        $newDefaults = new NewDefaults();

        return $specification->getProperties()->mapWithKeys(function (ModelPropertySpecification $property) use ($newDefaults) {
            if (!$newDefaults->canGuessDefaultFor($property)) {
                return [null => null];
            }

            return [$property->getName() => $newDefaults->guessDefaultFor($property)];
        })->filter()->toArray();
    }
}
