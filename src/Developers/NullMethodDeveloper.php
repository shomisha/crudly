<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullMethod;

class NullMethodDeveloper extends Developer
{
    public function develop(Specification $specification, CrudlySet $developedSet): NullMethod
    {
        return new NullMethod('null');
    }
}
