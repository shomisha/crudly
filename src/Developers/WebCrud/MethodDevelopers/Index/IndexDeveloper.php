<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\WebCrudMethodDeveloper;

/**
 * Class IndexDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class IndexDeveloper extends WebCrudMethodDeveloper
{
    protected function getMethodName(): string
    {
        return 'index';
    }

    protected function getArgumentsDevelopers(): array
    {
        return [];
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->nullDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getIndexAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getIndexMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getIndexResponseDeveloper();
    }
}
