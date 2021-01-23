<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AssertResponseModelIsTestModel extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel());
        $modelVar = Reference::variable($modelVarName);
        $responseModelVar = Reference::variable('response' . ucfirst($modelVarName));

        $assignResponseModel = Block::assign(
            $responseModelVar,
            Block::invokeMethod(
                Reference::variable('response'),
                'viewData',
                [$modelVarName]
            )
        );

        $assertModels = Block::invokeMethod(
            Reference::this(),
            'assertTrue',
            [
                Block::invokeMethod(
                    $modelVar,
                    'is',
                    [$responseModelVar]
                )
            ]
        );

        return Block::fromArray([
            $assignResponseModel,
            $assertModels
        ]);
    }
}
