<?php

namespace Shomisha\Crudly\Abstracts;

use Shomisha\Crudly\Contracts\Developer as DeveloperContract;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;

abstract class Developer implements DeveloperContract
{
    private DeveloperManagerAbstract $manager;

    private ModelSupervisor $modelSupervisor;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor)
    {
        $this->manager = $manager;
        $this->modelSupervisor = $modelSupervisor;
    }

    protected function getManager(): DeveloperManagerAbstract
    {
        return $this->manager;
    }

    protected function getModelSupervisor(): ModelSupervisor
    {
        return $this->modelSupervisor;
    }
}
