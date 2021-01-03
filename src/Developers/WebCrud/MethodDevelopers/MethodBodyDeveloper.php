<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\Contracts\Code;

abstract class MethodBodyDeveloper extends MethodDeveloper
{
    final public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $method = $this->getMethodFromSet($developedSet);

        $this->performDevelopment($specification, $method);

        return $method;
    }

    abstract protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod;

    abstract protected function performDevelopment(Specification $specification, CrudMethod $method);
}
