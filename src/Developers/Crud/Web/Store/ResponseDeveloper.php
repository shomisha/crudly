<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class ResponseDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): ReturnBlock
    {
        return $this->returnRedirectRouteBlock(
            $this->guessPluralModelVariableName($specification->getModel()->getName()) . '.index',
            ['success', "Successfully created new instance."]
        );
    }
}
