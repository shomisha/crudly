<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;

class AssertAllModelIdsPresentDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $responseVar = Reference::variable('response');
        $model = $specification->getModel();

        $modelsCollectionVar = Reference::variable($this->guessPluralModelVariableName($model));
        $singleModelVar = Reference::variable($this->guessSingularModelVariableName($model));
        $responseModelIds = Reference::variable('response' . ucfirst($this->guessSingularModelVariableName($model)) . 'Ids');

        return Block::fromArray([
            $this->getResponseModelIdsVariable($specification, $responseVar, $responseModelIds),
            Block::foreach($modelsCollectionVar, $singleModelVar)->do(
                Block::invokeMethod(
                    Reference::this(),
                    'assertContains',
                    [
                        Reference::objectProperty($singleModelVar, $specification->getPrimaryKey()->getName()),
                        $responseModelIds
                    ]
                )
            )
        ]);
    }

    protected function getResponseModelIdsVariable(CrudlySpecification $specification,
        Variable $responseVar,
        Variable $idsVar): AssignBlock
    {
        $modelsViewDataIndex = $this->guessPluralModelVariableName($specification->getModel());

        $ids = Block::invokeFunction(
            'collect',
            [
                Block::invokeMethod(
                    $responseVar,
                    'viewData',
                    [
                        $modelsViewDataIndex
                    ]
                )
            ]
        )->chain('pluck', [$specification->getPrimaryKey()->getName()]);

        return Block::assign($idsVar, $ids);
    }
}
