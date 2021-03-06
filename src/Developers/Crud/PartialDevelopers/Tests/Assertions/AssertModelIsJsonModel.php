<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AssertModelIsJsonModel extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $model = $specification->getModel();
        $primaryKeyName = $specification->getPrimaryKey()->getName();
        $modelVar = Reference::variable($this->guessSingularModelVariableName($model));
        $responseModelIdVar = Reference::variable('response' . ucfirst($this->guessSingularModelVariableName($model)) . 'Id');

        $getModelId = Block::assign(
            $responseModelIdVar,
            Block::invokeMethod(
                Reference::variable('response'),
                'json',
                [
                    "data.{$primaryKeyName}"
                ]
            )
        );

        $assertModelIdEqualsResponseId = Block::invokeMethod(
            Reference::this(),
            'assertEquals',
            [
                Reference::objectProperty($modelVar, $primaryKeyName),
                $responseModelIdVar
            ]
        );

        return Block::fromArray([
            $getModelId,
            $assertModelIdEqualsResponseId
        ]);
    }
}
