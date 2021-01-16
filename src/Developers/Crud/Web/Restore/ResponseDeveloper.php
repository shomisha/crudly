<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Restore;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class ResponseDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        $modelRouteNamespace = $this->guessPluralModelVariableName($specification->getModel()->getName());

        return $this->returnRedirectRouteBlock(
            "{$modelRouteNamespace}.index",
            ['success', 'Successfully restored instance.']
        );
    }
}
