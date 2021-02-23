<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\Values\ArrayValue;
use Shomisha\Stubless\Values\Value;

class ArrayDeveloper extends NullDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ArrayValue
    {
        return Value::array([]);
    }
}
