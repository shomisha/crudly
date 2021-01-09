<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Update;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class ValidateFillAndUpdateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\UpdateDeveloperManager getManager()
 */
class ValidateFillAndUpdateDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::fromArray([
            $this->getManager()->getUpdateValidateDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getUpdateFillDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getUpdateSaveDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
