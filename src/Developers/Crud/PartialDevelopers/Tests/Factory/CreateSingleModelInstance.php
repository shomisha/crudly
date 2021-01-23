<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class CreateSingleModelInstance extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $model = $specification->getModel();
        $modelVar = $this->guessSingularModelVariableName($model->getName());

        return Block::assign(
            $modelVar,
            Block::invokeStaticMethod(
                new Importable($model->getFullyQualifiedName()),
                'factory'
            )->chain('create')
        );
    }
}
