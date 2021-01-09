<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Index;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\References\Reference;

class ResponseDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $model = $specification->getModel();
        $modelsVariable = $this->guessPluralModelVariableName($model->getName());

        return $this->returnViewBlock(
            $this->guessModelViewNamespace($model) . '.index',
            [
                $modelsVariable => Reference::variable($modelsVariable)
            ]
        );
    }
}
