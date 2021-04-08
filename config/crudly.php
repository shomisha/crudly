<?php

use Shomisha\Crudly\Developers\Crud\Api;
use Shomisha\Crudly\Developers\Crud\PolicyDeveloper;
use Shomisha\Crudly\Developers\Crud\Web;
use Shomisha\Crudly\Developers\Factory;
use Shomisha\Crudly\Developers\Migration;
use Shomisha\Crudly\Developers\Model;
use Shomisha\Crudly\Developers\Tests;

return [
    'migrations' => Migration\MigrationDeveloper::class,

    'model' => Model\ModelDeveloper::class,

    'policy' => PolicyDeveloper::class,

    'web.form-request' => Web\FormRequest\WebFormRequestDeveloper::class,

    'web.controller' => Web\CrudControllerDeveloper::class,

    'api.form-request' => Api\FormRequest\ApiFormRequestDeveloper::class,

    'api.resource' => Api\Resource\ApiResourceDeveloper::class,

    'api.controller' => Api\CrudControllerDeveloper::class,

    'factory' => Factory\FactoryClassDeveloper::class,

    'web.tests' => Tests\Web\WebTestsDeveloper::class,

    'api.tests' => Tests\Api\ApiTestsDeveloper::class,
];
