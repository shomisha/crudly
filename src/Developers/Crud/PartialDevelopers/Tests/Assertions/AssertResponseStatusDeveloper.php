<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class AssertResponseStatusDeveloper extends Developer
{
    private int $status;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, int $status)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->status = $status;
    }

    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $responseVar = Reference::variable($this->getResponseVarName());

        return Block::invokeMethod(
            $responseVar,
            'assertStatus',
            [$this->status]
        );
    }

    protected function getResponseVarName(): string
    {
        return $this->parameterOrDefault('responseVarName', 'response');
    }
}
