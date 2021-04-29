<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\DeclarativeCode\Argument;

class ModelKeyArgumentDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Argument
    {
        $modelName = $specification->getModel()->getName();
        $primaryKeyName = $specification->getPrimaryKey()->getName();

        return Argument::name(
            $this->primaryKeyVariableName($modelName, $primaryKeyName)
        );
    }
}
