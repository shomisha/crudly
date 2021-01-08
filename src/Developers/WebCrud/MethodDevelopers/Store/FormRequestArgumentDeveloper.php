<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\Utilities\Importable;

class FormRequestArgumentDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Argument::name('request')->type(
            new Importable($this->guessFormRequestClass($specification->getModel()))
        );
    }
}
