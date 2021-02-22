<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullClass;

class NullClassDeveloper implements Developer
{
    private array $parameters;

    public function using(array $parameters): Developer
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function develop(Specification $specification, CrudlySet $developedSet): NullClass
    {
        return new NullClass();
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
