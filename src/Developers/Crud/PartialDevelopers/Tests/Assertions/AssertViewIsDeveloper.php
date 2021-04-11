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

class AssertViewIsDeveloper extends Developer
{
    private string $view;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, string $view)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->view = $view;
    }

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
                $this->guessModelViewNamespace($specification->getModel(), $this->view),
            ]
        );
    }

    protected function responseVariableName(): string
    {
        return $this->parameterOrDefault('responseVarName', 'response');
    }
}
