<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager() */
class ValidateFillAndSaveDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::fromArray([
            $this->getManager()->getStoreInstantiateDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getStoreValidationDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getStoreFillDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getStoreSaveDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
