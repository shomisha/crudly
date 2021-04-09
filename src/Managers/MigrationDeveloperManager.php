<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;

class MigrationDeveloperManager extends BaseDeveloperManager
{
    public function getMigrationUpMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('migrations.up-method');
    }

    public function getMigrationDownMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('migrations.down-method');
    }

    public function getMigrationFieldsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('migrations.fields');
    }
}
