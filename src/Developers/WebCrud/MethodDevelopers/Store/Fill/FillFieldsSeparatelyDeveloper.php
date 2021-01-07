<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store\Fill;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class FillFieldsSeparatelyDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelVar = Reference::variable($this->guessSingularModelVariableName($specification->getModel()->getName()));
        $requestVar = Reference::variable('request');

        return Block::fromArray($specification->getProperties()->map(
            function (ModelPropertySpecification $property) use ($modelVar, $requestVar) {
                if ($property->isPrimaryKey()) {
                    return;
                }

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
        )->filter()->toArray());
    }
}
