<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;
use Shomisha\Stubless\References\Reference;

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
        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($specification->getModel()->getName())
        );

        $getDeletedAt = Reference::objectProperty(
            Block::invokeMethod(
                $modelVar,
                'refresh'
            ),
            $specification->softDeletionColumnName()
        );

        return Block::invokeMethod(
            Reference::this(),
            'assertNotNull',
            [
                $getDeletedAt
            ]
        );
    }

    protected function assertHardDeleted(CrudlySpecification $specification, CrudlySet $developedSet): InvokeBlock
    {
        return $this->getManager()->getAssertDatabaseMissingModelDeveloper()->develop($specification ,$developedSet);
    }
}
