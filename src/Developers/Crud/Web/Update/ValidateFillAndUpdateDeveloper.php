<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Update;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class ValidateFillAndUpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\UpdateMethodDeveloperManager getManager()
 */
class ValidateFillAndUpdateDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::fromArray([
            $this->getManager()->getValidateDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getFillDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getSaveDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
