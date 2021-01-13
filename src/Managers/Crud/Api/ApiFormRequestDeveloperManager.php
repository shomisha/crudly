<?php

namespace Shomisha\Crudly\Managers\Crud\Api;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Developers\Crud\Api\FormRequest\Rules\RulesMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\Api\FormRequest\Rules\SpecialRulesDeveloper;
use Shomisha\Crudly\Managers\Crud\CrudDeveloperManager;

class ApiFormRequestDeveloperManager extends CrudDeveloperManager
{
    public function getAuthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullMethodDeveloper();
    }

    public function getRulesMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(RulesMethodDeveloper::class, $this);
    }

    public function getSpecialRulesDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->instantiateDeveloperWithManager(SpecialRulesDeveloper::class, $this);
    }
}
