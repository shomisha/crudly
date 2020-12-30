<?php

namespace Shomisha\Crudly\Managers;

use Illuminate\Contracts\Container\Container;
use Shomisha\Crudly\Config\DeveloperConfig;

abstract class BaseDeveloperManager
{
    private DeveloperConfig $config;

    private Container $container;

    public function __construct(DeveloperConfig $config, Container $container)
    {
        $this->config = $config;
        $this->container = $container;
    }

    protected function getConfig(): DeveloperConfig
    {
        return $this->config;
    }

    protected function getContainer(): Container
    {
        return $this->container;
    }
}
