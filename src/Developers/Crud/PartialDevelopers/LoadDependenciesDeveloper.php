<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class LoadDependenciesDeveloper extends MethodDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
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
}
