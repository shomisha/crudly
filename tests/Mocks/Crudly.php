<?php

namespace Shomisha\Crudly\Test\Mocks;

use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Crudly as ActualCrudly;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;

class Crudly extends ActualCrudly
{
    private CrudlySpecification $lastSpecification;

    private ?CrudlySet $developedSet = null;

    public function __construct(ModelSupervisor $modelSupervisor)
    {
        $this->setModelSupervisor($modelSupervisor);
    }

    public function develop(CrudlySpecification $specification): CrudlySet
    {
        $this->lastSpecification = $specification;

        return $this->getDevelopedSet();
    }

    public function withCrudlySet(CrudlySet $developedSet): self
    {
        $this->developedSet = $developedSet;

        return $this;
    }

    public function withModelSupervisor(ModelSupervisor $modelSupervisor): self
    {
        $this->setModelSupervisor($modelSupervisor);

        return $this;
    }

    public function getLastSpecification(): CrudlySpecification
    {
        return $this->lastSpecification;
    }

    public function hasLastSpecification(): bool
    {
        return isset($this->lastSpecification);
    }

    private function getDevelopedSet(): CrudlySet
    {
        if ($this->developedSet === null) {
            $this->developedSet = new CrudlySet();
        }

        return $this->developedSet;
    }
}
