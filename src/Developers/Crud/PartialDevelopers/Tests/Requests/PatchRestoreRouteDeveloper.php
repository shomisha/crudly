<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Abstractions\Code;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

/**
 * Class SendRestoreRequest
 *
 * @method \Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore\RestoreTestDeveloperManager getManager()
 */
class PatchRestoreRouteDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        return Block::assign(
            Reference::variable('response'),
            Block::invokeMethod(
                Reference::this(),
                'patch',
                [
                    $this->getRoute($specification, $developedSet)
                ]
            )
        );
    }

    protected function getRoute(CrudlySpecification $specification, CrudlySet $developedSet): Code
    {
        return $this->getManager()->getGetRouteDeveloper()->using(['route' => 'restore', 'withModel' => true])->develop($specification, $developedSet);
    }
}
