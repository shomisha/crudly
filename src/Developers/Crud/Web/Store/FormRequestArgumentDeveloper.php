<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\Utilities\Importable;

class FormRequestArgumentDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Argument::name('request')->type(
            new Importable($this->guessFormRequestClass($specification->getModel()))
        );
    }
}
