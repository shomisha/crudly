<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullMethod;

class NullMethodDeveloper implements Developer
{
    private array $parameters;

    public function using(array $parameters): Developer
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function develop(Specification $specification, CrudlySet $developedSet): NullMethod
    {
        return new NullMethod('null');
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
