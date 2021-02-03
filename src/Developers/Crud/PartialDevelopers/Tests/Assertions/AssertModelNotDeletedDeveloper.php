<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;

/** @method \Shomisha\Crudly\Managers\Tests\TestMethodDeveloperManager getManager() */
class AssertModelNotDeletedDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        if ($specification->hasSoftDeletion()) {
            return $this->assertNotSoftDeleted($specification, $developedSet);
        }

        return $this->assertNotHardDeleted($specification, $developedSet);
    }

    protected function assertNotSoftDeleted(CrudlySpecification $specification, CrudlySet $developedSet): Code
    {
        return $this->getManager()->getAssertSoftDeletedColumnIsNullDeveloper()->develop($specification, $developedSet);
    }

    protected function assertNotHardDeleted(CrudlySpecification $specification, CrudlySet $developedSet): Code
    {
        return $this->getManager()->getAssertDatabaseHasModelDeveloper()->develop($specification, $developedSet);
    }
}
