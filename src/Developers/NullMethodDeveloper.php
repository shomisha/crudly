<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullMethod;
use Shomisha\Stubless\Contracts\Code;

class NullMethodDeveloper extends Developer
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return new NullMethod('null');
    }
}
