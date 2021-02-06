<?php

namespace Shomisha\Crudly\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Shomisha\Crudly\CrudlyServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CrudlyServiceProvider::class,
        ];
    }
}
