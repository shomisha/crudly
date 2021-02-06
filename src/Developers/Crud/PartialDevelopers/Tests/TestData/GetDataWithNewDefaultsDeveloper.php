<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\NewDefaults;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class GetDataWithNewDefaultsDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        return Block::assign(
            Reference::variable('data'),
            $this->getDataWithDefaults($specification)
        );
    }

    protected function getDataWithDefaults(CrudlySpecification $specification): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::this(),
            $this->getModelDataMethodName($specification->getModel()),
            [
                NewDefaults::forProperties($specification->getProperties())->guess()
            ]
        );
    }
}
