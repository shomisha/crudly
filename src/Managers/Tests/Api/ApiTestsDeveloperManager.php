<?php

namespace Shomisha\Crudly\Managers\Tests\Api;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\Api\Methods as MethodDevelopers;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Developers\Tests\Web\Methods\InvalidDataProviderDeveloper;
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

    public function getShowDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Show\ShowTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Show\ShowTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedShowDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Show\UnauthorizedShowTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Show\UnauthorizedShowTestDeveloperManager::class)
        );
    }

    public function getStoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Store\StoreTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Store\StoreTestDeveloperManager::class)
        );
    }

    public function getInvalidDataProviderDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            InvalidDataProviderDeveloper::class,
            $this,
        );
    }

    public function getInvalidStoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Store\InvalidStoreTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Store\InvalidStoreTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedStoreDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Store\UnauthorizedStoreTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Store\UnauthorizedStoreTestDeveloperManager::class)
        );
    }

    public function getUpdateDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Update\UpdateTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Update\UpdateTestDeveloperManager::class)
        );
    }

    public function getInvalidUpdateDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Update\InvalidUpdateTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Update\InvalidUpdateTestDeveloperManager::class)
        );
    }

    public function getUnauthorizedUpdateDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(
            MethodDevelopers\Update\UnauthorizedUpdateTestDeveloper::class,
            $this->instantiateManager(MethodDeveloperManagers\Update\UnauthorizedUpdateTestDeveloperManager::class)
        );
    }

    public function getDestroyDeveloper(): Developer
    {

    }

    public function getUnauthorizedDestroyDeveloper(): Developer
    {

    }

    public function getForceDeleteDeveloper(): Developer
    {

    }

    public function getUnauthorizedForceDeleteDeveloper(): Developer
    {

    }

    public function getRestoreDeveloper(): Developer
    {

    }

    public function getUnauthorizedRestoreDeveloper(): Developer
    {

    }
}
