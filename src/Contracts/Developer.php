<?php

namespace Shomisha\Crudly\Contracts;

use Shomisha\Stubless\Contracts\Code;

interface Developer
{
    public function develop(Specification $specification): Code;
}
