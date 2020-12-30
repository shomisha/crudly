<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Migration\MigrationDeveloper;
use Shomisha\Crudly\Developers\Model\ModelDeveloper;

class DeveloperManager extends BaseDeveloperManager
{
    public function getModelDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return new ModelDeveloper($this->getModelManager());
    }

    private function getModelManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(ModelDeveloperManager::class);
    }

    public function getMigrationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return new MigrationDeveloper($this->getMigrationManager());
    }

    private function getMigrationManager(): BaseDeveloperManager
    {
        return $this->instantiateManager(MigrationDeveloperManager::class);
    }

    private function instantiateManager(string $managerClass): BaseDeveloperManager
    {
        return new $managerClass($this->getConfig(), $this->getContainer());
    }
}
