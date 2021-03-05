<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class CreateMultipleModelInstances extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $model = $specification->getModel();

        return Block::assign(
            $this->guessPluralModelVariableName($model),
            Block::invokeStaticMethod(
                new Importable($model->getFullyQualifiedName()),
                'factory'
            )->chain('count', [5])->chain('create')
        );
    }
}
