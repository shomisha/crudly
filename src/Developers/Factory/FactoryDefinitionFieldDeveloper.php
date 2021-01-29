<?php

namespace Shomisha\Crudly\Developers\Factory;

use Illuminate\Support\Facades\DB;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\FakerMethodGuesser;
use Shomisha\Crudly\Specifications\ForeignKeySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\ImperativeCode\InvokeStaticMethodBlock;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;
use Shomisha\Stubless\Values\Closure;
use Shomisha\Stubless\Values\Value;

class FactoryDefinitionFieldDeveloper extends FactoryDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\ModelPropertySpecification $property */
    public function develop(Specification $property, CrudlySet $developedSet): Code
    {
        if ($property->isForeignKey()) {
            return $this->invokeForeignKeyFactoryDefinition($property);
        }

        return $this->invokeFakerMethodForProperty($property);
    }

    protected function invokeForeignKeyFactoryDefinition(ModelPropertySpecification $property)
    {
        $relationshipModel = $this->getModelSupervisor()->parseModelNameFromTable($property->getForeignKeySpecification()->getForeignKeyTable());

        if ($this->factoryExists($relationshipModel)) {
            return $this->loadFromFactory($relationshipModel);
        }

        if ($this->getModelSupervisor()->modelExists($relationshipModel)) {
            return $this->loadFromModel($relationshipModel, $property->getForeignKeySpecification()->getForeignKeyField());
        }

        return $this->loadFromRelationshipTable($property->getForeignKeySpecification());
    }

    protected function loadFromFactory(ModelName $model): InvokeStaticMethodBlock
    {
        return Block::invokeStaticMethod(
            new Importable($model->getFullyQualifiedName()),
            'factory'
        );
    }

    protected function loadFromModel(ModelName $model, string $fieldName): Closure
    {
        $loadModelBlock = Block::invokeStaticMethod(
            new Importable($model->getFullyQualifiedName()),
            'query'
        )->chain('inRandomOrder')->chain('first');

        $getKeyBlock = Reference::objectProperty(
            $loadModelBlock,
            $fieldName
        );

        return Value::closure(
            [Argument::name('arguments')],
            Block::return($getKeyBlock)
        );
    }

    protected function loadFromRelationshipTable(ForeignKeySpecification $specification): Closure
    {
        $loadInstanceBlock = Block::invokeStaticMethod(
            new Importable(DB::class),
            'table',
            [$specification->getForeignKeyTable()]
        )->chain('inRandomOrder')->chain('first');

        $getKeyBlock = Reference::objectProperty(
            $loadInstanceBlock,
            $specification->getForeignKeyField()
        );

        return Value::closure(
            [Argument::name('arguments')],
            Block::return($getKeyBlock)
        );
    }


    protected function invokeFakerMethodForProperty(ModelPropertySpecification $property): Code
    {
        $faker = Reference::objectProperty(
            Reference::this(),
            'faker'
        );

        if ($property->isUnique()) {
            $faker = Block::invokeMethod($faker, 'unique');
        }

        return with(new FakerMethodGuesser($faker))->guess($property);
    }
}
