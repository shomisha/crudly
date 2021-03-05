<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\OldDefaults;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;
use Shomisha\Stubless\Values\ArrayValue;
use Shomisha\Stubless\Values\Value;

class CreateModelWithOldDefaultsDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $modelVar = Reference::variable(
            $this->guessSingularModelVariableName($specification->getModel())
        );

        return Block::assign(
            $modelVar,
            $this->getCreateModelBlock($specification, $developedSet)
        );
    }

    protected function getCreateModelBlock(CrudlySpecification $specification, CrudlySet $developedSet): InvokeBlock
    {
        return Block::invokeStaticMethod(
            new Importable($specification->getModel()->getFullyQualifiedName()),
            'factory'
        )->chain('create', [$this->getOldOverride($specification, $developedSet)]);
    }

    protected function getOldOverride(CrudlySpecification $specification, CrudlySet $developedSet): ArrayValue
    {
        return Value::array(
            OldDefaults::forProperties($specification->getProperties())->guess()
        );
    }
}
