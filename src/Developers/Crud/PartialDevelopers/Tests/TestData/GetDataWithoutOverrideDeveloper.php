<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class GetDataWithoutOverrideDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        return Block::assign(
            Reference::variable('data'),
            Block::invokeMethod(
                Reference::this(),
                $this->getModelDataMethodName($specification->getModel())
            )
        );
    }
}
