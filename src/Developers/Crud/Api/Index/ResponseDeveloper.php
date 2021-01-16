<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Index;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class ResponseDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        $model = $specification->getModel();

        return Block::return(
            Block::invokeStaticMethod(
                new Importable($this->guessApiResourceClass($model)),
                'collection',
                [Reference::variable($this->guessPluralModelVariableName($model->getName()))]
            )
        );
    }
}
