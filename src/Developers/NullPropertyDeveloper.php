<?php

namespace Shomisha\Crudly\Developers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Stubless\NullProperty;
use Shomisha\Stubless\DeclarativeCode\ClassProperty;

class NullPropertyDeveloper implements Developer
{
    private array $parameters;

    public function using(array $parameters): Developer
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function develop(Specification $specification, CrudlySet $developedSet): ClassProperty
    {
        return new NullProperty('null');
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
