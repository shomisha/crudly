<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\Utilities\Importable;

class ImplicitBindArgumentsDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $model = $specification->getModel();
        $modelArgName = $this->guessSingularModelVariableName($model->getName());

        return Argument::name($modelArgName)->type(new Importable($model->getFullyQualifiedName()));
    }
}
