<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class PutDataToUpdateRouteDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        return Block::assign(
            Reference::variable('response'),
            Block::invokeMethod(
                Reference::this(),
                'put',
                [
                    $this->getRoute($specification, $developedSet),
                    Reference::variable('data'),
                ]
            )
        );
    }

    protected function getRoute(CrudlySpecification $specification, CrudlySet $developedSet): Code
    {
        return $this->getManager()->getGetRouteDeveloper()->using(['route' => 'update', 'withModel' => true])->develop($specification, $developedSet);
    }
}
