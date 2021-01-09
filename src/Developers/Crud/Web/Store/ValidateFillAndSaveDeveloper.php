<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\Crud\Web\StoreDeveloperManager getManager() */
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
