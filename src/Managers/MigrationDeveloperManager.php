<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Migration\DownMethodDeveloper;
use Shomisha\Crudly\Developers\Migration\MigrationFieldsDeveloper;
use Shomisha\Crudly\Developers\Migration\UpMethodDeveloper;

class MigrationDeveloperManager extends BaseDeveloperManager
{
    public function getMigrationUpMethodDeveloper(): Developer
    {
        // TODO: refactor this to make it overridable via config
        return new UpMethodDeveloper($this);
    }

    public function getMigrationDownMethodDeveloper(): Developer
    {
        // TODO: refactor this to make it overridable via config
        return new DownMethodDeveloper($this);
    }

    public function getMigrationFieldsDeveloper(): Developer
    {
        // TODO: refactor this to make it overridable via config
        return new MigrationFieldsDeveloper($this);
    }
}
