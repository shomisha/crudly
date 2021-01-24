<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AssertResponseModelsMissingSingularModel extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $model = $specification->getModel();
        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($specification->getModel()->getName())
        );
        $modelIdsVar = Reference::variable(
            "response" . ucfirst($this->guessSingularModelVariableName($model)) . 'Ids'
        );

        return Block::fromArray([
            $this->getManager()->getModelIdsFromResponseDeveloper()->develop($specification, $developedSet),
            Block::invokeMethod(
                Reference::this(),
                'assertNotContains',
                [
                    $modelIdsVar,
                    Reference::objectProperty(
                        $modelVar,
                        $specification->getPrimaryKey()->getName()
                    )
                ]
            )
        ]);
    }
}
