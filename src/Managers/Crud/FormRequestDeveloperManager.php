<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules\RulesMethodDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules\SpecialRulesDeveloper;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Validation\PropertyValidationRulesDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

class FormRequestDeveloperManager extends BaseDeveloperManager
{
    public function getAuthorizeMethodDeveloper(): Developer
    {
        // TODO: refactor this to support overriding developers
        return $this->nullMethodDeveloper();
    }

    public function getValidationRulesDeveloper(): PropertyValidationRulesDeveloper
    {
        return $this->instantiateDeveloperWithManager(PropertyValidationRulesDeveloper::class, $this);
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
