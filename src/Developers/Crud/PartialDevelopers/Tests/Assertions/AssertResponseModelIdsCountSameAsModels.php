<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertResponseModelIdsCountSameAsModels extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $model = $specification->getModel();

        $modelsVar = Reference::variable($this->guessPluralModelVariableName($model));
        $responseModelIdsVar = Reference::variable("response" . ucfirst($this->guessSingularModelVariableName($model)) . "Ids");

        return Block::invokeMethod(
            Reference::this(),
            'assertCount',
            [
                Block::invokeMethod($modelsVar, 'count'),
                $responseModelIdsVar,
            ]
        );
    }
}
