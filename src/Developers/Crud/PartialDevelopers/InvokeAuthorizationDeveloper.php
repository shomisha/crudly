<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class InvokeAuthorizationDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): InvokeMethodBlock
    {
        $args = [
            $this->getAction()
        ];

        if ($this->withClass()) {
            $args[] = Reference::classReference(new Importable($specification->getModel()->getFullyQualifiedName()));
        }

        if ($this->withModel()) {
            $args[] = Reference::variable($this->guessSingularModelVariableName($specification->getModel()));
        }

        return Block::invokeMethod(
            Reference::this(),
            'authorize',
            $args
        );
    }

    protected function getAction(): string
    {
        return $this->getParameter('action');
    }

    protected function withModel(): bool
    {
        return $this->parameterOrDefault('withModel', false);
    }

    protected function withClass(): bool
    {
        return $this->parameterOrDefault('withClass', false);
    }
}
