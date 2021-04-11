<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Managers\BaseDeveloperManager;

abstract class FormRequestDeveloperManager extends BaseDeveloperManager
{
    public function getAuthorizeMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('methods.authorize')
        );
    }

    public function getRulesMethodDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('methods.rules')
        );
    }

    public function getSpecialRulesDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('methods.rules.special')
        );
    }

    public function getValidationRulesDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('methods.rules.validation')
        );
    }

    abstract protected function qualifyConfigKey(string $key): string;
}
