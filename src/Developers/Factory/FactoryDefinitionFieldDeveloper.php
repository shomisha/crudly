<?php

namespace Shomisha\Crudly\Developers\Factory;

use Illuminate\Support\Facades\DB;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\ModelPropertyType;
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

        switch ($property->getType()) {
            case ModelPropertyType::BOOL():
                return $this->invokeBooleanFakerMethod($faker);
            case ModelPropertyType::STRING():
                return $this->invokeStringFakerMethod($faker);
            case ModelPropertyType::EMAIL():
                return $this->invokeEmailFakerMethod($faker);
            case ModelPropertyType::TEXT():
                return $this->invokeTextFakerMethod($faker);
            case ModelPropertyType::INT():
                return $this->invokeIntegerFakerMethod($faker);
            case ModelPropertyType::BIG_INT():
                return $this->invokeBigIntegerFakerMethod($faker);
            case ModelPropertyType::TINY_INT():
                return $this->invokeTinyIntegerFakerMethod($faker);
            case ModelPropertyType::FLOAT():
                return $this->invokeFloatFakerMethod($faker);
            case ModelPropertyType::DATE():
                return $this->invokeDateFakerMethod($faker);
            case ModelPropertyType::TIMESTAMP():
                return $this->invokeTimestampFakerMethod($faker);
            case ModelPropertyType::DATETIME():
                return $this->invokeDatetimeFakerMethod($faker);
            case ModelPropertyType::JSON():
                return $this->invokeJsonFakerMethod($faker);
        }
    }

    protected function invokeBooleanFakerMethod(Code $faker): Code
    {
        return $this->appendInvocationToFaker($faker, 'boolean');
    }

    protected function invokeStringFakerMethod(Code $faker): Code
    {
        // MySQL default string duration provided as argument
        return $this->appendInvocationToFaker($faker, 'text', [255]);
    }

    protected function invokeEmailFakerMethod(Code $faker): Code
    {
        return $this->appendPropertyToFaker($faker, 'email');
    }

    protected function invokeTextFakerMethod(Code $faker): Code
    {
        // Near max text length provided as argument
        return $this->appendInvocationToFaker($faker, 'text', [65000]);
    }

    protected function invokeIntegerFakerMethod(Code $faker): Code
    {
        // TODO: account for unsigned fields
        // MySQL max int provided as second argument
        return $this->appendInvocationToFaker($faker, 'numberBetween', [0, 32767]);
    }

    protected function invokeBigIntegerFakerMethod(Code $faker): Code
    {
        // TODO: account for unsigned fields
        // Default value provided as second argument
        return $this->appendInvocationToFaker($faker, 'numberBetween', [0, 2147483647]);
    }

    protected function invokeTinyIntegerFakerMethod(Code $faker): Code
    {
        // TODO: account for unsigned fields
        return $this->appendInvocationToFaker($faker, 'numberBetween', [0, 127]);
    }

    protected function invokeFloatFakerMethod(Code $faker): Code
    {
        return $this->appendInvocationToFaker($faker, 'randomFloat');
    }

    protected function invokeDateFakerMethod(Code $faker): Code
    {
        return $this->appendInvocationToFaker($faker, 'date');
    }

    protected function invokeTimestampFakerMethod(Code $faker): Code
    {
        return $this->appendInvocationToFaker($faker, 'dateTime');
    }

    protected function invokeDatetimeFakerMethod(Code $faker): Code
    {
        return $this->appendInvocationToFaker($faker, 'dateTime');
    }

    protected function invokeJsonFakerMethod(Code $faker): Code
    {
        return Value::array([1, 2, 3]);
    }

    protected function appendPropertyToFaker(Code $faker, string $property): Code
    {
        return Reference::objectProperty($faker, $property);
    }

    protected function appendInvocationToFaker(Code $faker, string $method, array $arguments = []): Code
    {
        if ($faker instanceof InvokeMethodBlock) {
            return $faker->chain($method, $arguments);
        }

        return Block::invokeMethod($faker, $method, $arguments);
    }
}
