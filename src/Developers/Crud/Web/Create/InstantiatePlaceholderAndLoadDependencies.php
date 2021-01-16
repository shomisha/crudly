<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class InstantiatePlaceholderAndLoadDependencies
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\CreateMethodDeveloperManager getManager()
 */
class InstantiatePlaceholderAndLoadDependencies extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        return Block::fromArray([
            $this->getManager()->getLoadDependenciesDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getInstantiateDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
