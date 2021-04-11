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
        return new class($this->app) extends TestMethodDeveloperManager
        {
            public function __construct(Container $container)
            {
                parent::__construct(new DeveloperConfig(), $container);
            }

            protected function qualifyConfigKey(string $key): string
            {
                return $key;
            }
        };
    }
}
