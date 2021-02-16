<?php

namespace Shomisha\Crudly\Test\Unit;

use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Test\Mocks\DeveloperManagerMock;
use Shomisha\Crudly\Test\Mocks\ModelSupervisorMock;
use Shomisha\Crudly\Test\TestCase;

abstract class DeveloperTestCase extends TestCase
{
    protected DeveloperManagerMock $manager;

    protected ModelSupervisor $modelSupervisor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = new DeveloperManagerMock();
        $this->modelSupervisor = new ModelSupervisorMock();
        $this->app->instance(ModelSupervisor::class, $this->modelSupervisor);
    }
}
