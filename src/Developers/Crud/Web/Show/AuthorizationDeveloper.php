<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class AuthorizationDeveloper extends MethodDeveloper
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
