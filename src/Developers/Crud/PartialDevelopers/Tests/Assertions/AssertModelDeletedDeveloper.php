<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertModelDeletedDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        if ($specification->hasSoftDeletion()) {
            return $this->assertSoftDeleted($specification, $developedSet);
        }

        return $this->assertHardDeleted($specification, $developedSet);
    }

    protected function assertSoftDeleted(CrudlySpecification $specification, CrudlySet $developedSet): Block
    {
        return Block::fromArray([
            $this->getManager()->getRefreshModelDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getAssertSoftDeletedDeveloper()->develop($specification, $developedSet)
        ]);
    }

    protected function assertHardDeleted(CrudlySpecification $specification, CrudlySet $developedSet): Code
    {
        return $this->getManager()->getAssertHardDeletedDeveloper()->develop($specification ,$developedSet);
    }
}
