<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class ForceDeleteAuthorizationDeveloper extends MethodDeveloper
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