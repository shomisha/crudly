<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Load;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;
use Shomisha\Stubless\Utilities\Importable;

class LoadAllDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        // TODO: add note to docs that main and response developers assume some naming conventions which can be accessed by inheriting the MethodBodyDeveloper
        $variableName = $this->guessPluralModelVariableName($specification->getModel()->getName());
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        return Block::assign(
            Variable::name($variableName),
            Block::invokeStaticMethod(
                Reference::classReference(new Importable($fullModelName)),
                'all'
            )
        );
    }
}
