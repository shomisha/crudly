<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $model = $specification->getModel();
        $modelVarName = $this->guessSingularModelVariableName($model->getName());

        return $this->returnViewBlock(
            $this->guessModelViewNamespace($model) . '.show',
            [
                $modelVarName => Reference::variable($modelVarName)
            ]
        );
    }
}
