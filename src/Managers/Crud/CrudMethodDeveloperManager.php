<?php

namespace Shomisha\Crudly\Managers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldUsingRequestInputDeveloper;

abstract class CrudMethodDeveloperManager extends CrudDeveloperManager
{
    public function getArgumentsDeveloper(): array
    {
        $developerClasses = $this->getConfig()->getConfiguredDevelopersGroup(
            $this->qualifyConfigKey('arguments')
        );

        return array_map(function (string $developerClass) {
            return $this->instantiateDeveloperWithManager($developerClass, $this);
        }, $developerClasses);
    }

    public function getLoadDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('load')
        );
    }

    public function getAuthorizationDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('authorization')
        );
    }

    public function getMainDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('main')
        );
    }

    public function getResponseDeveloper(): Developer
    {
        return $this->instantiateDeveloperByKey(
            $this->qualifyConfigKey('response')
        );
    }

    public function getFillFieldDeveloper(): FillFieldUsingRequestInputDeveloper
    {
        return $this->instantiateDeveloperWithManager(FillFieldUsingRequestInputDeveloper::class, $this);
    }

    abstract protected function qualifyConfigKey(string $key): string;
}
