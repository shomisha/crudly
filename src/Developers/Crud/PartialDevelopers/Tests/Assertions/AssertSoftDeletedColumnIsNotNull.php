<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertSoftDeletedColumnIsNotNull extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($specification->getModel()->getName())
        );
        $softDeletedColumn = $specification->softDeletionColumnName();

        return Block::invokeMethod(
            Reference::this(),
            'assertNotNull',
            [
                Reference::objectProperty(
                    $modelVar,
                    $softDeletedColumn
                )
            ]
        );
    }
}
