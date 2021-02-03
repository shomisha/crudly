<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertDatabaseHasModelDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $primaryKey = $specification->getPrimaryKey()->getName();
        $modelIdVar = Reference::objectProperty(
            Reference::variable($this->guessSingularModelVariableName($specification->getModel())),
            $primaryKey
        );

        return Block::invokeMethod(
            Reference::this(),
            'assertDatabaseHas',
            [
                $this->guessTableName($specification->getModel()),
                [
                    $primaryKey => $modelIdVar
                ],
            ]
        );
    }
}
