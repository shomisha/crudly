<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Destroy;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;

class ResponseDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelRouteNamespace = $this->guessPluralModelVariableName($specification->getModel()->getName());

        return $this->returnRedirectRouteBlock(
            "{$modelRouteNamespace}.index",
            ['success', 'Successfully deleted instance.']
        );
    }
}
