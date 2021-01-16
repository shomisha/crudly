<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Authorization;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class ViewAllAuthorizationDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        return Block::invokeMethod(
            Reference::this(),
            'authorize',
            [
                'viewAll',
                Reference::classReference(new Importable($fullModelName))
            ]
        );
    }
}
