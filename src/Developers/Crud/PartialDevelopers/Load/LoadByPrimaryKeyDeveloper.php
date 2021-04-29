<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Load;

use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class LoadByPrimaryKeyDeveloper extends CrudDeveloper
{
    private bool $withTrashed;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, bool $withTrashed = true)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->withTrashed = $withTrashed;
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): AssignBlock
    {
        $model = $specification->getModel();
        $modelName = $model->getName();
        $modelVarName = $this->guessSingularModelVariableName($modelName);
        $primaryKeyName = $specification->getPrimaryKey()->getName();

        $loadInvocation = Block::invokeStaticMethod(
            new Importable($specification->getModel()->getFullyQualifiedName()),
            'query'
        );

        if ($this->withTrashed) {
            $loadInvocation = $loadInvocation->chain('withTrashed');
        }

        $loadInvocation->chain('findOrFail', [
            Reference::variable($this->primaryKeyVariableName($modelName, $primaryKeyName))
        ]);

        return Block::assign(
            Reference::variable($modelVarName),
            $loadInvocation
        );
    }
}
