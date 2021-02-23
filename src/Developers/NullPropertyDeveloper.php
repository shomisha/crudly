<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullProperty;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;

class NullPropertyDeveloper extends NullDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ClassProperty
    {
        return new NullProperty('null');
    }
}
