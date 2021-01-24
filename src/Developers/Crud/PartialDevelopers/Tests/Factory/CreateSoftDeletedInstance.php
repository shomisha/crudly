<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;
use Shomisha\Stubless\Values\ArrayValue;
use Shomisha\Stubless\Values\Value;

class CreateSoftDeletedInstance extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $model = $specification->getModel();
        $modelVar = $this->guessSingularModelVariableName($model);

        return Block::assign(
            $modelVar,
            Block::invokeStaticMethod(
                new Importable($model->getFullyQualifiedName()),
                'factory'
            )->chain('create', [$this->getSoftDeletedOverride($specification)])
        );
    }

    protected function getSoftDeletedOverride(CrudlySpecification $specification): ArrayValue
    {
        return Value::array([
            $specification->softDeletionColumnName() => Block::invokeFunction('now'),
        ]);
    }
}
