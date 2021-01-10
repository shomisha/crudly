<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

class ReturnNoContentDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::return(
            Block::invokeFunction('response')->chain('noContent')
        );
    }
}
