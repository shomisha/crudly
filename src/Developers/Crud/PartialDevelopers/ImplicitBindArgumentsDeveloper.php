<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\Utilities\Importable;

class ImplicitBindArgumentsDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Argument
    {
        $model = $specification->getModel();
        $modelArgName = $this->guessSingularModelVariableName($model->getName());

        return Argument::name($modelArgName)->type(new Importable($model->getFullyQualifiedName()));
    }
}
