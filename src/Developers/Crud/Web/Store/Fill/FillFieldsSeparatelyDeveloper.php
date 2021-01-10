<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store\Fill;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class FillFieldsSeparatelyDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelVar = Reference::variable($this->guessSingularModelVariableName($specification->getModel()->getName()));
        $requestVar = Reference::variable('request');

        $properties = $specification->getProperties()->except($specification->getPrimaryKey()->getName());
        return Block::fromArray($properties->map(
            function (ModelPropertySpecification $property) use ($modelVar, $requestVar) {
                $propertyName = $property->getName();

                return Block::assign(
                    Reference::objectProperty($modelVar, $propertyName),
                    Block::invokeMethod(
                        $requestVar,
                        'input',
                        [$propertyName]
                    )
                );
            }
        )->toArray());
    }
}
