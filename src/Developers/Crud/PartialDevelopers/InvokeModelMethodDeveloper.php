<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class InvokeModelMethodDeveloper extends Developer
{
    private string $method;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, string $method)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->method = $method;
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $modelVar = Reference::variable($this->getModelVarName($specification));

        return Block::invokeMethod(
            $modelVar,
            $this->method,
            $this->getArguments()
        );
    }

    protected function getModelVarName(CrudlySpecification $specification): string
    {
        return $this->parameterOrDefault(
            'modelVarName',
            $this->guessSingularModelVariableName($specification->getModel())
        );
    }

    protected function getArguments(): array
    {
        return $this->parameterOrDefault('arguments', []);
    }
}
