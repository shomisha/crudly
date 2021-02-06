<?php

namespace Shomisha\Crudly\Developers\Crud\Web\Store\Fill;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;

class FillFieldUsingRequestInputDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $requestVar = Reference::variable($this->requestVarName());
        $modelVar = Reference::variable($this->modelVarName($specification));
        $propertyName = $this->getParameter('property');

        return Block::assign(
            Reference::objectProperty($modelVar, $propertyName),
            Block::invokeMethod($requestVar, 'input', [$propertyName])
        );
    }

    protected function requestVarName(): string
    {
        return $this->parameterOrDefault('requestVarName', 'request');
    }

    protected function modelVarName(CrudlySpecification $specification): string
    {
        return $this->parameterOrDefault(
            'modelVarName',
            $this->guessSingularModelVariableName($specification->getModel())
        );
    }
}
