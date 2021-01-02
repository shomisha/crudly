<?php

namespace Shomisha\Crudly\Contracts;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\Contracts\Code;

interface Developer
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code;
}
