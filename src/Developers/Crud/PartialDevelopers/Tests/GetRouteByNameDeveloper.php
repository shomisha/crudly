<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeFunctionBlock;
use Shomisha\Stubless\References\Reference;

class GetRouteByNameDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeFunctionBlock
    {
        $arguments = [
            $this->getRouteName($specification),
        ];

        if ($this->parameterOrDefault('withModel', false)) {
            $arguments[] = Reference::variable(
                $this->guessSingularModelVariableName($specification->getModel()->getName())
            );
        }

        return Block::invokeFunction(
            'route', $arguments
        );
    }

    protected function getRouteName(CrudlySpecification $specification): string
    {
        return $this->getRouteNamespace($specification) . ".{$this->getParameter('route')}";
    }

    protected function getRouteNamespace(CrudlySpecification $specification): string
    {
        return $this->guessPluralModelVariableName($specification->getModel()->getName());
    }
}
