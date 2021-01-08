<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;

class ResponseDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return $this->returnRedirectRouteBlock(
            $this->guessPluralModelVariableName($specification->getModel()->getName()) . '.index',
            ['success', "Successfully created new instance."]
        );
    }
}
