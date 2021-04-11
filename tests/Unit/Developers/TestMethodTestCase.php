<?php

namespace Shomisha\Crudly\Test\Unit\Developers;

use Illuminate\Contracts\Container\Container;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;

class TestMethodTestCase extends DeveloperTestCase
{
    protected function getTestMethodDeveloperManager(): TestMethodDeveloperManager
    {
        return new class($this->app, $this->getDeveloperConfig()) extends TestMethodDeveloperManager
        {
            public function __construct(Container $container, DeveloperConfig $config)
            {
                parent::__construct($config, $container);
            }

            protected function qualifyConfigKey(string $key): string
            {
                return $key;
            }
        };
    }
}
