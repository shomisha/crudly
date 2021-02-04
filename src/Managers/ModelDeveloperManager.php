<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Model\CastsDeveloper;
use Shomisha\Crudly\Developers\Model\RelationshipDeveloper;
use Shomisha\Crudly\Developers\Model\SoftDeletionDeveloper;

class ModelDeveloperManager extends BaseDeveloperManager
{
    public function getSoftDeletionDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(SoftDeletionDeveloper::class, $this);
    }

    public function getCastsDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(CastsDeveloper::class, $this);
    }

    public function getRelationshipsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RelationshipDeveloper::class, $this);
    }
}
