<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class LoadRelationshipsDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelVarName = $this->guessSingularModelVariableName($specification->getModel()->getName());

        $relationships = $this->extractRelationshipsFromSpecification($specification);

        if (empty($relationships)) {
            return Block::fromArray([]);
        }

        return Block::invokeMethod(
            Reference::variable($modelVarName),
            'load',
            [$relationships]
        );
    }
}
