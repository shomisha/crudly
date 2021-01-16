<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class InvokeRestoreMethodDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::variable($this->guessSingularModelVariableName($specification->getModel()->getName())),
            'restore'
        );
    }
}
