<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;

class ModelDeveloperManager extends BaseDeveloperManager
{
    public function getSoftDeletionDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('model.soft-deletion');
    }

    public function getCastsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('model.casts');
    }

    public function getRelationshipsDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey('model.relationships');
    }
}
