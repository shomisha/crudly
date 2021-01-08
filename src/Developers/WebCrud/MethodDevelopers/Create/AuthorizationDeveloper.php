<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class AuthorizationDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $fullModelName = $specification->getModel()->getFullyQualifiedName();

        return Block::invokeMethod(
            Reference::this(),
            'authorize',
            [
                'create',
                Reference::classReference(new Importable($fullModelName))
            ]
        );
    }
}
