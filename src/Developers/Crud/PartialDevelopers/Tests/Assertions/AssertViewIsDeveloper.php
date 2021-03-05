<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertViewIsDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $responseVar = Reference::variable(
            $this->responseVariableName()
        );

        return Block::invokeMethod(
            $responseVar,
            'assertViewIs',
            [
                $this->guessModelViewNamespace($specification->getModel(), $this->getParameter('view')),
            ]
        );
    }

    protected function responseVariableName(): string
    {
        return $this->parameterOrDefault('responseVarName', 'response');
    }
}
