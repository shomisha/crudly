<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class ForceDeleteAuthorizationDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelName = $specification->getModel()->getName();

        return Block::invokeMethod(
            Reference::this(),
            'authorize',
            [
                'forceDelete',
                Reference::variable($this->guessSingularModelVariableName($modelName))
            ]
        );
    }
}
