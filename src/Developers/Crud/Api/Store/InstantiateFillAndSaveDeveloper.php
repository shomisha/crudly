<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class InstantiateFillAndSaveDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\StoreMethodDeveloperManager getManager()
 */
class InstantiateFillAndSaveDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        return Block::fromArray([
            $this->getManager()->getValidationDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getInstantiateDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getFillDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getSaveDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
