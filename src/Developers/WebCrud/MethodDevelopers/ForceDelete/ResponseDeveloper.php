<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\ForceDelete;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;

class ResponseDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelRouteNamespace = $this->guessPluralModelVariableName($specification->getModel()->getName());

        return $this->returnRedirectRouteBlock(
            "{$modelRouteNamespace}.index",
            ['success', 'Successfully deleted instance.']
        );
    }
}
