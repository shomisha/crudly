<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullClass;

class NullClassDeveloper implements Developer
{
    public function using(array $parameters): Developer
    {
        
    }

    public function develop(Specification $specification, CrudlySet $developedSet): NullClass
    {
        return new NullClass();
    }
}
