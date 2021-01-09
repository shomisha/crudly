<?php

namespace Shomisha\Crudly\Managers\Crud\Web;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\AuthorizationDeveloper as CreateAuthorizationDeveloper;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\InstantiatePlaceholderAndLoadDependencies;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create\ResponseDeveloper as CreateResponseDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class CreateDeveloperManager extends CrudDeveloperManager
{
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
}
