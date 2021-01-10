<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Update;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;

class ResponseDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelRouteNamespace = $this->guessPluralModelVariableName($specification->getModel()->getName());

        return $this->returnRedirectRouteBlock(
            "{$modelRouteNamespace}.index",
            ['success', 'Successfully updated instance.']
        );
    }
}
