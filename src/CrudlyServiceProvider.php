<?php

namespace Shomisha\Crudly;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Shomisha\Crudly\Commands\CrudlyWizard;
use Shomisha\Crudly\Contracts\ModelNameParser as ModelNameParserContract;
use Shomisha\Crudly\Utilities\ModelNameParser;

class CrudlyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerCrudly();

        $this->commands([
            CrudlyWizard::class,
        ]);
    }

    private function registerCrudly(): void
    {
        $this->registerModelNameParser();

        $this->app->bind(Crudly::class, function (Container $app) {
            $modelNameParser = $app->get(ModelNameParserContract::class);

            return new Crudly($app, $modelNameParser);
        });
    }

    private function registerModelNameParser(): void
    {
        $this->app->bind(ModelNameParserContract::class, function (Container $app) {
            return new ModelNameParser();
        });
    }
}
