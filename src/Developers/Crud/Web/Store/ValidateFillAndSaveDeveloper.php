<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\Crud\Web\StoreMethodDeveloperManager getManager() */
class ValidateFillAndSaveDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        return Block::fromArray([
            $this->getManager()->getStoreInstantiateDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getValidationDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getFillDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getSaveDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
