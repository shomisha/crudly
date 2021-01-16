<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class ReturnSingleResourceDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        $model = $specification->getModel();

        return Block::return(
            Block::instantiate(
                new Importable($this->guessApiResourceClass($model)),
                [Reference::variable($this->guessSingularModelVariableName($model))]
            )
        );
    }
}
