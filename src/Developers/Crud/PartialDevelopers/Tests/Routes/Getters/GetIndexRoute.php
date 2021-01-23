<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Routes\Getters;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;
use Shomisha\Stubless\References\Reference;

class GetIndexRoute extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeBlock
    {
        return Block::invokeMethod(
            Reference::this(),
            'getIndexRoute',
        );
    }
}
