<?php

namespace Shomisha\Crudly;

use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;
use Shomisha\Crudly\Commands\CrudlyWizard;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Contracts\ModelSupervisor as ModelSupervisorContract;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\DeveloperManager;
use Shomisha\Crudly\Utilities\FileSaver\FileSaver;
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

        $this->registerFileSaver();

        $this->registerDeveloperManager();

        $this->registerDeveloperConfig();

        $this->app->bind(Crudly::class, function (Container $app) {
            $modelNameParser = $app->get(ModelSupervisorContract::class);

            return new Crudly(
                $app->get(ModelSupervisorContract::class),
                $app->get(BaseDeveloperManager::class),
                $app->get(FileSaver::class)
            );
        });
    }

    private function registerModelSupervisor(): void
    {
        $this->app->bind(ModelSupervisorContract::class, function (Container $app) {
            return new ModelSupervisor($app['files'], $app['path'], $this->app->getNamespace());
        });
    }

    private function registerFileSaver(): void
    {
        $this->app->bind(FileSaver::class, function (Container $app) {
            return new FileSaver(
                $app->get(ModelSupervisorContract::class),
                $app->basePath(),
                $app['path']
            );
        });
    }

    private function registerDeveloperManager(): void
    {
        $this->app->singleton(BaseDeveloperManager::class, function (Container $app) {
            return new DeveloperManager(
                $this->app->get(DeveloperConfig::class),
                $app
            );
        });
    }

    private function registerDeveloperConfig(): void
    {
        $this->app->singleton(DeveloperConfig::class, function (Container $app) {
            $defaultsPath = __DIR__ . '/../config/defaults.php';

            return tap(new DeveloperConfig(
                $app->get('config')->get('crudly', [])
            ))->withDefaults(new DeveloperConfig(require $defaultsPath));
        });
    }
}
