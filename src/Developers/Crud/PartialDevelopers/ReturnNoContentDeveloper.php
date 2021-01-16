<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class ReturnNoContentDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        return Block::return(
            Block::invokeFunction('response')->chain('noContent')
        );
    }
}
