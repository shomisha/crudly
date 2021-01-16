<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\ImperativeCode\Block;

class NullDeveloper implements Developer
{
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        return Block::fromArray([]);
    }
}
