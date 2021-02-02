<?php

namespace Shomisha\Crudly\Managers\Tests\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\Api\Methods as MethodDevelopers;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers as MethodDeveloperManagers;
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

    public function getIndexTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Index\IndexTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Index\IndexTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Index\UnauthorizedIndexTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Index\UnauthorizedIndexTestDeveloperManager::class)
        );
}
