<?php

namespace Shomisha\Crudly\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\CrudlyServiceProvider;
use Shomisha\Stubless\Contracts\DelegatesImports;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CrudlyServiceProvider::class,
        ];
    }

    public function assertModelIncludedInCode(string $model, DelegatesImports $code, ?string $message = null): void
    {
        $modelFullName = "App\Models\\{$model}";

        $this->assertEquals(
            $modelFullName,
            optional($code->getDelegatedImports()[$modelFullName] ?? null)->getName(),
            $message ?? sprintf("Failed asserting that model %s is included in %s", $model, get_class($code))
        );
    }

    public function getDeveloperConfig(): DeveloperConfig
    {
        return $this->app->get(DeveloperConfig::class);
    }
}
