<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertResponseStatusDeveloper extends Developer
{
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $responseVar = Reference::variable($this->getResponseVarName());

        return Block::invokeMethod(
            $responseVar,
            'assertStatus',
            [$this->getParameter('status')]
        );
    }

    protected function getResponseVarName(): string
    {
        return $this->parameterOrDefault('responseVarName', 'response');
    }
}
