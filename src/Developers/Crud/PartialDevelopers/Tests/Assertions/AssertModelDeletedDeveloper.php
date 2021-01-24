<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;

class AssertModelDeletedDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeBlock
    {
        if ($specification->hasSoftDeletion()) {
            return $this->assertSoftDeleted($specification, $developedSet);
        }

        return $this->assertHardDeleted($specification, $developedSet);
    }

    protected function assertSoftDeleted(CrudlySpecification $specification, CrudlySet $developedSet): InvokeBlock
    {
        return $this->getManager()->getAssertSoftDeletedColumnIsNotNullDeveloper()->develop($specification, $developedSet);
    }

    protected function assertHardDeleted(CrudlySpecification $specification, CrudlySet $developedSet): InvokeBlock
    {
        return $this->getManager()->getAssertDatabaseMissingModelDeveloper()->develop($specification ,$developedSet);
    }
}
