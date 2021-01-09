<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Edit;

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
        $modelName = $specification->getModel()->getName();

        return Block::invokeMethod(
            Reference::this(),
            'authorize',
            [
                'update',
                Reference::variable($this->guessSingularModelVariableName($modelName))
            ]
        );
    }
}
