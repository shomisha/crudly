<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\OldDefaults;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AssertModelHasOldValuesDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $assertions = Block::fromArray([]);
        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($specification->getModel())
        );

        foreach ($this->getOldFields($specification) as $fieldName => $newValue) {
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

    protected function getOldFields(CrudlySpecification $specification): array
    {
        return OldDefaults::forProperties($specification->getProperties())->guess();
    }
}
