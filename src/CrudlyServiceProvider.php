<?php

namespace Shomisha\Crudly;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Shomisha\Crudly\Commands\CrudlyWizard;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Contracts\ModelNameParser as ModelNameParserContract;
use Shomisha\Crudly\Managers\DeveloperManager;
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

        $this->registerDeveloperManager();

        $this->app->bind(Crudly::class, function (Container $app) {
            $modelNameParser = $app->get(ModelNameParserContract::class);

            return new Crudly(
                $app['files'],
                $app->get(ModelNameParserContract::class),
                $app->get(DeveloperManager::class),
                $app['path']
            );
        });
    }

    private function registerModelNameParser(): void
    {
        $this->app->bind(ModelNameParserContract::class, function (Container $app) {
            return new ModelNameParser();
        });
    }

    private function registerDeveloperManager(): void
    {
        $this->app->singleton(DeveloperManager::class, function (Container $app) {
            $developerConfig = new DeveloperConfig([]);

            return new DeveloperManager($developerConfig, $app);
        });
    }
}
