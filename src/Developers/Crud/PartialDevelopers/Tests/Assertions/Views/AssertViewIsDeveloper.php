<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\Views;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

abstract class AssertViewIsDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::variable('response'),
            'assertViewIs',
            [
                $this->getExpectedView($specification->getModel())
            ]
        );
    }

    abstract protected function getExpectedView(ModelName $modelName): string;
}
