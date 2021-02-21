<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers;

use Illuminate\Support\Facades\DB;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;
use Shomisha\Stubless\Values\AssignableValue;

class LoadDependenciesDeveloper extends CrudDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Block
    {
        $blocks = [];

        foreach ($this->extractRelationshipModels($specification) as $relationshipModelName) {
            $blocks[] = Block::assign(
                $this->guessPluralModelVariableName($relationshipModelName),
                $this->loadDependencies($relationshipModelName),
            );
        }

        return Block::fromArray($blocks);
    }

    /** @return \Shomisha\Crudly\Data\ModelName[] */
    protected function extractRelationshipModels(CrudlySpecification $specification): array
    {
        return array_map(function (string $tableName) {
            return $this->getModelSupervisor()->parseModelNameFromTable($tableName);
        }, $this->extractForeignKeyTablesFromSpecification($specification));
    }

    protected function loadDependencies(ModelName $model): AssignableValue
    {
        if ($this->getModelSupervisor()->modelExists($model->getName())) {
            return Block::invokeStaticMethod(
                new Importable($model->getFullyQualifiedName()),
                'all'
            );
        }

        return Block::invokeStaticMethod(
            new Importable(DB::class),
            'table',
            [$this->guessTableName($model)]
        )->chain('get');
    }
}
