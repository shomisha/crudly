<?php

namespace Shomisha\Crudly\Managers\Tests\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\AuthenticateUserMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\AuthorizeUserMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\DeauthorizeUserMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataPrimeDefaultsDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataMethodDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataSpecialDefaultsDeveloper;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Create\CreateTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Create\UnauthorizedCreateTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Destroy\DestroyTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Destroy\UnauthorizedDestroyTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Edit\EditTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Edit\UnauthorizedEditTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\ForceDelete\ForceDeleteTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\ForceDelete\UnauthorizedForceDeleteTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\IndexTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\UnauthorizedIndexTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Restore\RestoreTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Restore\UnauthorizedRestoreTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore\UnauthorizedRestoreTestDeveloperManager;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Show\ShowTestDeveloper;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Show\UnauthorizedShowTestDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create\CreateTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create\UnauthorizedCreateTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Destroy\DestroyTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Destroy\UnauthorizedDestroyTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit\EditTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit\UnauthorizedEditTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\ForceDelete\ForceDeleteTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\ForceDelete\UnauthorizedForceDeleteTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index\IndexTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index\UnauthorizedIndexTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore\RestoreTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Show\ShowTestDeveloperManager;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Show\UnauthorizedShowTestDeveloperManager;

class WebTestsDeveloperManager extends BaseDeveloperManager
{
    public function getAuthenticateUserMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(AuthenticateUserMethodDeveloper::class, $this);
    }

    public function getAuthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(AuthorizeUserMethodDeveloper::class, $this);
    }

    public function getDeauthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(DeauthorizeUserMethodDeveloper::class, $this);
    }

    public function getDataMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetModelDataMethodDeveloper::class, $this);
    }

    public function getModelDataSpecialDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetModelDataSpecialDefaultsDeveloper::class, $this);
    }

    public function getModelDataPrimeDefaultsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(GetModelDataPrimeDefaultsDeveloper::class, $this);
    }

    /** @return \Shomisha\Crudly\Abstracts\Developer[] */
    public function getRouteMethodDevelopers(): array
    {
        // TODO: refactor this to support overriding developers
        return [
            $this->instantiateDeveloperWithManager(RouteGetters\GetIndexRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetShowRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetCreateRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetStoreRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetEditRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetUpdateRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetDestroyRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetForceDeleteRouteMethodDeveloper::class, $this),
            $this->instantiateDeveloperWithManager(RouteGetters\GetRestoreRouteMethodDeveloper::class, $this),
        ];
    }

    public function getIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(IndexTestDeveloper::class, $this->getIndexTestDeveloperManager());
    }

    public function getIndexWillNotContainSoftDeletedModelsTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    private function getIndexTestDeveloperManager(): IndexTestDeveloperManager
    {
        return $this->instantiateManager(IndexTestDeveloperManager::class);
    }

    public function getUnauthorizedIndexTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedIndexTestDeveloper::class, $this->getUnauthorizedIndexTestDeveloperManager());
    }

    private function getUnauthorizedIndexTestDeveloperManager(): UnauthorizedIndexTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedIndexTestDeveloperManager::class);
    }

    public function getShowTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ShowTestDeveloper::class, $this->getShowTestDeveloperManager());
    }

    private function getShowTestDeveloperManager(): ShowTestDeveloperManager
    {
        return $this->instantiateManager(ShowTestDeveloperManager::class);
    }

    public function getUnauthorizedShowTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedShowTestDeveloper::class, $this->getUnauthorizedShowDeveloperManager());

    }

    private function getUnauthorizedShowDeveloperManager(): UnauthorizedShowTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedShowTestDeveloperManager::class);
    }

    public function getCreateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateTestDeveloper::class, $this->getCreateTestDeveloperManager());
    }

    private function getCreateTestDeveloperManager(): CreateTestDeveloperManager
    {
        return $this->instantiateManager(CreateTestDeveloperManager::class);
    }

    public function getUnauthorizedCreateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedCreateTestDeveloper::class, $this->getUnauthorizedCreateTestDeveloperManager());
    }

    private function getUnauthorizedCreateTestDeveloperManager(): UnauthorizedCreateTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedCreateTestDeveloperManager::class);
    }

    public function getStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getStoreInvalidDataProviderDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getInvalidDataStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedStoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getEditTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(EditTestDeveloper::class, $this->getEditTestDeveloperManager());
    }

    private function getEditTestDeveloperManager(): EditTestDeveloperManager
    {
        return $this->instantiateManager(EditTestDeveloperManager::class);
    }

    public function getUnauthorizedEditTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedEditTestDeveloper::class, $this->getUnauthorizedEditTestDeveloperManager());
    }

    protected function getUnauthorizedEditTestDeveloperManager(): UnauthorizedEditTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedEditTestDeveloperManager::class);
    }

    public function getUpdateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUpdateInvalidDataProviderDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getInvalidDataUpdateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUnauthorizedUpdateTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getDestroyTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(DestroyTestDeveloper::class, $this->getDestroyTestDeveloperManager());
    }

    private function getDestroyTestDeveloperManager(): DestroyTestDeveloperManager
    {
        return $this->instantiateManager(DestroyTestDeveloperManager::class);
    }

    public function getUnauthorizedDestroyTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedDestroyTestDeveloper::class, $this->getUnauthorizedDestroyTestDeveloperManager());
    }

    private function getUnauthorizedDestroyTestDeveloperManager(): UnauthorizedDestroyTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedDestroyTestDeveloperManager::class);
    }

    public function getForceDeleteTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ForceDeleteTestDeveloper::class, $this->getForceDeleteTestDeveloperManager());
    }

    public function getForceDeleteTestDeveloperManager(): ForceDeleteTestDeveloperManager
    {
        return $this->instantiateManager(ForceDeleteTestDeveloperManager::class);
    }

    public function getUnauthorizedForceDeleteTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedForceDeleteTestDeveloper::class, $this->getUnauthorizedForceDeleteTestDeveloperManager());
    }

    public function getUnauthorizedForceDeleteTestDeveloperManager(): UnauthorizedForceDeleteTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedForceDeleteTestDeveloperManager::class);
    }

    public function getRestoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RestoreTestDeveloper::class, $this->getRestoreTestDeveloperManager());
    }

    private function getRestoreTestDeveloperManager(): RestoreTestDeveloperManager
    {
        return $this->instantiateManager(RestoreTestDeveloperManager::class);
    }

    public function getUnauthorizedRestoreTestDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(UnauthorizedRestoreTestDeveloper::class, $this->getUnauthorizedRestoreTestDeveloperManager());
    }

    private function getUnauthorizedRestoreTestDeveloperManager(): UnauthorizedRestoreTestDeveloperManager
    {
        return $this->instantiateManager(UnauthorizedRestoreTestDeveloperManager::class);
    }
}
