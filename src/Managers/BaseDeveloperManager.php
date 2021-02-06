<?php

namespace Shomisha\Crudly\Managers;

use Illuminate\Contracts\Container\Container;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\NullDeveloper;
use Shomisha\Crudly\Developers\NullMethodDeveloper;

abstract class BaseDeveloperManager
{
    private DeveloperConfig $config;

    private Container $container;

    public function __construct(DeveloperConfig $config, Container $container)
    {
        $this->config = $config;
        $this->container = $container;
    }

    public function nullDeveloper(): NullDeveloper
    {
        return $this->instantiateDeveloperWithManager(NullDeveloper::class, $this);
    }

    public function nullMethodDeveloper(): NullMethodDeveloper
    {
        return $this->instantiateDeveloperWithManager(NullMethodDeveloper::class, $this);
    }

    protected function getConfig(): DeveloperConfig
    {
        return $this->config;
    }

    protected function getContainer(): Container
    {
        return $this->container;
    }

    protected function instantiateManager(string $managerClass): BaseDeveloperManager
    {
        return new $managerClass($this->config, $this->container);
    }

    protected function instantiateDeveloperWithManager(string $developerClass, BaseDeveloperManager $manager): Developer
    {
        return $this->container->make($developerClass, [
            'manager' => $manager
        ]);
    }
}
