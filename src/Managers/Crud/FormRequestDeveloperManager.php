<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules\RulesMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules\SpecialRulesDeveloper;

class FormRequestDeveloperManager extends CrudDeveloperManager
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
