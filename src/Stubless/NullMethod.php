<?php

namespace Shomisha\Crudly\Stubless;

use Shomisha\Stubless\DeclarativeCode\ClassMethod;

class NullMethod extends ClassMethod
{
    public function __construct(string $name)
    {
        $this->setName($name);
    }

    public function getPrintableNodes(): array
    {
        return [];
    }
}
