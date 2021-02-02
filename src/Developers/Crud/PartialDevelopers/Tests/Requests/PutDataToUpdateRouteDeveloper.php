<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class PutDataToUpdateRouteDeveloper extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        return Block::assign(
            Reference::variable('response'),
            Block::invokeMethod(
                Reference::this(),
                'put',
                [
                    Reference::variable('data'),
                ]
            )
        );
    }
}
