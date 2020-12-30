<?php

namespace Shomisha\Crudly\Abstracts;

use Shomisha\Crudly\Contracts\Developer as DeveloperContract;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;

abstract class Developer implements DeveloperContract
{
    private DeveloperManagerAbstract $manager;

    public function __construct(DeveloperManagerAbstract $manager)
    {
        $this->manager = $manager;
    }

    protected function getManager(): DeveloperManagerAbstract
    {
        return $this->manager;
    }
}
