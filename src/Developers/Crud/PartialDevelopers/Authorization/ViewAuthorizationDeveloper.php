<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class ViewAuthorizationDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
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
