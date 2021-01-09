<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Index\Main;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\References\Variable;
use Shomisha\Stubless\Utilities\Importable;

class PaginateDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $variableName = $this->guessPluralModelVariableName($specification->getModel()->getName());
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        return Block::assign(
            Variable::name($variableName),
            Block::invokeStaticMethod(
                Reference::classReference(new Importable($fullModelName)),
                'paginate'
            )
        );
    }
}
