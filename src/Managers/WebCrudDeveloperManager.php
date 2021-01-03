<?php

namespace Shomisha\Crudly\Managers;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\AuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\IndexDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\Main\PaginateDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index\ResponseDeveloper;

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
    }

    public function getCreateMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
    }

    public function getStoreMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
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
}
