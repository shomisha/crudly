<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\MethodInvocation;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class InvokeSaveMethodDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::invokeMethod(
            Reference::variable($this->guessSingularModelVariableName($specification->getModel()->getName())),
            'save'
        );
    }
}
