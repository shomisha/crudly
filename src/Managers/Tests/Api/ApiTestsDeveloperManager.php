<?php

namespace Shomisha\Crudly\Managers\Tests\Api;

use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Managers\Tests\TestClassDeveloperManager;

class ApiTestsDeveloperManager extends TestClassDeveloperManager
{
    public function getRouteMethodDevelopers(): array
    {
        return [
            $this->instantiateDeveloperWithManager(RouteGetters\GetIndexRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetShowRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetStoreRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetUpdateRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetDestroyRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetForceDeleteRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetRestoreRouteMethodDeveloper::class, $this),
        ];
    }
}
