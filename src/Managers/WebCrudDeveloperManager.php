<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\InstantiateDeveloper;
use Shomisha\Crudly\Developers\WebCrud\LoadDependenciesDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\AuthorizationDeveloper as CreateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\CreateDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\InstantiatePlaceholderAndLoadDependencies;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\ResponseDeveloper as CreateResponseDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\AuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\IndexDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\Main\PaginateDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\ResponseDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show\AuthorizationDeveloper as ShowAuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show\ImplicitBindArgumentsDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show\LoadRelationshipsDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show\ResponseDeveloper as ShowResponseDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show\ShowDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\AuthorizationDeveloper as StoreAuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\Fill\FillFieldsSeparatelyDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\FormRequestArgumentDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\ResponseDeveloper as StoreResponseDeveloper;
use Shomisha\Crudly\Developers\WebCrud\SaveDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\StoreDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\ValidateFillAndSaveDeveloper;

class WebCrudDeveloperManager extends BaseDeveloperManager
{
    public function getIndexMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(IndexDeveloper::class, $this);
    }

    public function getIndexAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(AuthorizationDeveloper::class, $this);
    }

    public function getIndexMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(PaginateDeveloper::class, $this);
    }

    public function getIndexResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ResponseDeveloper::class, $this);
    }

    public function getShowMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ShowDeveloper::class, $this);
    }

    public function getShowArgumentsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->getImplicitBindArgumentDeveloper();
    }

    public function getShowLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getShowAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperWithManager(ShowAuthorizationDeveloper::class, $this);
    }

    public function getShowMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(LoadRelationshipsDeveloper::class, $this);
    }

    public function getShowResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ShowResponseDeveloper::class, $this);
    }

    public function getCreateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateDeveloper::class, $this);
    }

    public function getCreateLoadDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullDeveloper();
    }

    public function getCreateAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateAuthorizationDeveloper::class, $this);
    }

    public function getCreateMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(InstantiatePlaceholderAndLoadDependencies::class, $this);
    }

    public function getCreateResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(CreateResponseDeveloper::class, $this);
    }

    public function getStoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreDeveloper::class, $this);
    }

    public function getStoreArgumentsDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FormRequestArgumentDeveloper::class, $this);
    }

    public function getStoreAuthorizationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreAuthorizationDeveloper::class, $this);
    }

    public function getStoreMainDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(ValidateFillAndSaveDeveloper::class, $this);
    }

    public function getStoreInstantiateDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->getInstantiateDeveloper();
    }

    public function getStoreValidationDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        // TODO: implement a $this->validate validation developer
        return $this->nullDeveloper();
    }

    public function getStoreFillDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(FillFieldsSeparatelyDeveloper::class, $this);
    }

    public function getStoreSaveDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(SaveDeveloper::class, $this);
    }

    public function getStoreResponseDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(StoreResponseDeveloper::class, $this);
    }

    public function getEditMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getUpdateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getDestroyMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getImplicitBindArgumentDeveloper(): ImplicitBindArgumentsDeveloper
    {
        return $this->instantiateDeveloperWithManager(ImplicitBindArgumentsDeveloper::class, $this);
    }

    public function getFormRequestArgumentDeveloper(): FormRequestArgumentDeveloper
    {
        return $this->instantiateDeveloperWithManager(FormRequestArgumentDeveloper::class, $this);
    }

    public function getInstantiateDeveloper(): InstantiateDeveloper
    {
        return $this->instantiateDeveloperWithManager(InstantiateDeveloper::class, $this);
    }

    public function getLoadDependenciesDeveloper(): LoadDependenciesDeveloper
    {
        return $this->instantiateDeveloperWithManager(LoadDependenciesDeveloper::class, $this);
    }
}
