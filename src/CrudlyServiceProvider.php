<?php

namespace Shomisha\Crudly;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Shomisha\Crudly\Commands\CrudlyWizard;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Contracts\ModelSupervisor as ModelSupervisorContract;
use Shomisha\Crudly\Managers\DeveloperManager;
use Shomisha\Crudly\Utilities\ModelSupervisor;

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
        $this->registerModelSupervisor();

        $this->registerDeveloperManager();

        $this->app->bind(Crudly::class, function (Container $app) {
            $modelNameParser = $app->get(ModelSupervisorContract::class);

            return new Crudly(
                $app['files'],
                $app->get(ModelSupervisorContract::class),
                $app->get(DeveloperManager::class),
                $app['path']
            );
        });
    }

    private function registerModelSupervisor(): void
    {
        $this->app->bind(ModelSupervisorContract::class, function (Container $app) {
            return new ModelSupervisor($app['files'], $app['path']);
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
