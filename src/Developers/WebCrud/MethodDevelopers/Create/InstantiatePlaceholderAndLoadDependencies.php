<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\AssignBlock;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class InstantiatePlaceholderAndLoadDependencies extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['create'];
    }

    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
    {
        $method->withMainBlock(Block::fromArray([
            $this->loadDependencies($specification),
            $this->createPlaceholderModelInstance($specification),
        ]));
    }

    private function loadDependencies(CrudlySpecification $specification): Block
    {
        $blocks = [];

        foreach ($this->extractRelationshipModels($specification) as $modelName) {
            $blocks[] = Block::assign(
                $this->guessPluralModelVariableName($modelName),
                Block::invokeStaticMethod(
                    new Importable($modelName->getFullyQualifiedName()),
                    'all'
                )
            );
        }

        return Block::fromArray($blocks);
    }

    /** @return \Shomisha\Crudly\Data\ModelName[] */
    private function extractRelationshipModels(CrudlySpecification $specification): array
    {
        return array_map(function (string $tableName) {
            return $this->getModelSupervisor()->parseModelNameFromTable($tableName);
        }, $this->extractRelationshipTablesFromSpecification($specification));
    }

    private function createPlaceholderModelInstance(CrudlySpecification $specification): AssignBlock
    {
        $model = $specification->getModel();

        return Block::assign(
            $this->guessSingularModelVariableName($model),
            Block::instantiate(new Importable($model->getFullyQualifiedName()))
        );
    }
}
