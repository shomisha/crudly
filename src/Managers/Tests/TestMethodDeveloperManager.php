<?php

namespace Shomisha\Crudly\Managers\Tests;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\DeveloperManager;

abstract class TestMethodDeveloperManager extends DeveloperManager
{
    abstract public function getArrangeDeveloper(): Developer;

    abstract public function getActDeveloper(): Developer;

    abstract public function getAssertDeveloper(): Developer;
}
