<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class GetRouteDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        return Block::invokeMethod(
            Reference::this(),
            $this->getMethodName($specification),
            $this->getMethodArguments($specification)
        );
    }

    protected function getMethodName(CrudlySpecification $specification): string
    {
        return "get" . ucfirst($this->getParameter('route')) . 'Route';
    }

    protected function getMethodArguments(CrudlySpecification $specification): array
    {
        if ($this->parameterOrDefault('withModel', false)) {
            return [Reference::variable($this->getModelVarName($specification))];
        }

        return [];
    }

    protected function getModelVarName(CrudlySpecification $specification): string
    {
        return $this->parameterOrDefault(
            'modelVarName',
            $this->guessSingularModelVariableName($specification->getModel())
        );
    }
}
