<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\Values\NullValue;
use Shomisha\Stubless\Values\Value;

class NullValueDeveloper implements Developer
{
    public function using(array $parameters): Developer
    {
    }

    public function develop(Specification $specification, CrudlySet $developedSet): NullValue
    {
        return Value::null();
    }
}
