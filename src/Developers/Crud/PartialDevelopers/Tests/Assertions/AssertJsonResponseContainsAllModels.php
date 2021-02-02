<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

/** @method \Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Index\IndexTestDeveloperManager getManager() */
class AssertJsonResponseContainsAllModels extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $model = $specification->getModel();
        $modelsVar = Reference::variable(
            $this->guessPluralModelVariableName($model)
        );
        $singleModelVar = Reference::variable(
            $this->guessSingularModelVariableName($model)
        );
        $responseModelIdsVar = Reference::variable("response" . ucfirst($this->guessSingularModelVariableName($model)) . "Ids");

        return Block::fromArray([
            Block::foreach($modelsVar, $singleModelVar)->do(Block::invokeMethod(
                Reference::this(),
                'assertContains',
                [
                    Reference::objectProperty($singleModelVar, $specification->getPrimaryKey()->getName()),
                    $responseModelIdsVar
                ]
            ))
        ]);
    }
}
