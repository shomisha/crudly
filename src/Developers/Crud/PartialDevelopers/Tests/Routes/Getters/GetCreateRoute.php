<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Routes\Getters;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class GetCreateRoute extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::this(),
            'getCreateRoute'
        );
    }
}
