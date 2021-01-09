<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Edit;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class ValidateFillAndUpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\EditDeveloperManager getManager()
 */
class ValidateFillAndUpdateDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::fromArray([
        ]);
    }
}
