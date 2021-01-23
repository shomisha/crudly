<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class InvokeCreateAndAuthenticateUserDeveloper extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        return Block::assign(
            Reference::variable('user'),
            Block::invokeMethod(
                Reference::this(),
                'createAndAuthenticateUser'
            )
        );
    }
}
