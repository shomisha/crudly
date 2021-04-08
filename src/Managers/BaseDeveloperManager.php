<?php

namespace Shomisha\Crudly\Managers;

use Illuminate\Contracts\Container\Container;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\NullDeveloper;
use Shomisha\Crudly\Developers\NullMethodDeveloper;
use Shomisha\Crudly\Developers\NullPropertyDeveloper;

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
        return new NullDeveloper();
    }

    public function nullMethodDeveloper(): NullMethodDeveloper
    {
        return new NullMethodDeveloper();
    }

    public function nullPropertyDeveloper(): NullPropertyDeveloper
    {
        return new NullPropertyDeveloper();
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
        return $this->container->make($managerClass, [
            'config' => $this->getConfig(),
            'container' => $this->getContainer(),
        ]);
    }

    protected function instantiateDeveloperWithManager(string $developerClass, BaseDeveloperManager $manager): Developer
    {
        [$developerClass, $arguments] = $this->parseConfiguredClass($developerClass);

        return $this->container->make($developerClass, array_merge([
            'manager' => $manager,
        ], $arguments));
    }

    protected function instantiateDeveloperByKey(string $key, ?BaseDeveloperManager $manager = null): Developer
    {
        return $this->instantiateDeveloperWithManager(
            $this->getConfig()->getConfiguredDeveloperClass(
                $key
            ),
            $manager ?? $this
        );
    }

    private function parseConfiguredClass(string $configuredClass): array
    {
        $parts = explode('.', $configuredClass);

        $class = $parts[0];
        $arguments = [];

        if (count($parts) == 2) {
            $arguments = collect(explode(',', $parts[1]))->mapWithKeys(function (string $nameAndValue) {
                [$name, $value] = explode(':', $nameAndValue);

                return [$name => $value];
            })->toArray();
        }

        return [$class, $arguments];
    }
}
