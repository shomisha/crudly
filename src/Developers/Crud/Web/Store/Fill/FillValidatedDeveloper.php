<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store\Fill;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class FillValidatedDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::invokeMethod(
            Reference::variable(
                $this->guessSingularModelVariableName($specification->getModel()->getName())
            ),
            'fill',
            [
                Block::invokeMethod(
                    Reference::variable('request'),
                    'validated'
                )
            ]
        );
    }
}
