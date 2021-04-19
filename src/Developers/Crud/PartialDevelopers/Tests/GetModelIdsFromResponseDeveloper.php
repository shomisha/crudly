<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class GetModelIdsFromResponseDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $model = $specification->getModel();
        $responseVar = Reference::variable('response');
        $modelsViewDataIndex = $this->guessPluralModelVariableName($model);
        $idsVar = Reference::variable("response" . ucfirst($this->guessSingularModelVariableName($model)) . 'Ids');

        $ids = Block::invokeMethod(
            $responseVar,
            'viewData',
            [
                $modelsViewDataIndex,
            ]
        )->chain('pluck', [$specification->getPrimaryKey()->getName()]);

        return Block::assign($idsVar, $ids);
    }
}
