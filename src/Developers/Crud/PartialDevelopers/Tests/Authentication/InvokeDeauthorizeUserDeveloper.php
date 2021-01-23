<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class InvokeDeauthorizeUserDeveloper extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::this(),
            'deauthorizeUser',
            [Reference::variable('user')]
        );
    }
}
