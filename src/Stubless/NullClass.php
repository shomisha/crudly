<?php

namespace Shomisha\Crudly\Stubless;

use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class NullClass extends ClassTemplate
{
    public function __construct()
    {
        parent::__construct('null');
    }

    public function getPrintableNodes(): array
    {
        return [];
    }

    public function getImports(): array
    {
        return [];
    }
}
