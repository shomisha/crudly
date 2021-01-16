<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class ViewAuthorizationDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel()->getName());

        return Block::invokeMethod(
            Reference::this(),
            'authorize',
            [
                'view',
                Reference::variable($modelVarName)
            ]
        );
    }
}
