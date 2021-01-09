<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

/**
 * Class InstantiatePlaceholderAndLoadDependencies
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\WebCrudDeveloperManager getManager()
 */
class InstantiatePlaceholderAndLoadDependencies extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::fromArray([
            $this->getManager()->getLoadDependenciesDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getInstantiateDeveloper()->develop($specification, $developedSet),
        ]);
    }
}
