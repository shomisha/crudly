<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertDatabaseMissingModelDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $model = $specification->getModel();

        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($model->getName())
        );
        $primaryKey = $specification->getPrimaryKey()->getName();
        $tableName = $this->guessTableName($model);

        return Block::invokeMethod(
            Reference::this(),
            'assertDatabaseMissing',
            [
                $tableName,
                [
                    $primaryKey => Reference::objectProperty($modelVar, $primaryKey)
                ]
            ]
        );
    }
}
