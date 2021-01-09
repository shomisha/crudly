<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class ShowDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\ShowDeveloperManager getManager()
 */
class ShowDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'show';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [
            $this->getManager()->getShowArgumentsDeveloper()
        ];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getShowLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getShowAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getShowMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getShowResponseDeveloper();
    }
}
