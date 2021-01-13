<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest\Rules;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Utilities\Importable;

class SpecialRulesDeveloper extends ValidationDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $specialProperties = $this->getSpecialProperties($specification);
        if ($specialProperties->isEmpty()) {
            return Block::fromArray([]);
        }

        $ruleDeclarations = [];
        $dependentRules = [];
        foreach ($specialProperties as $property) {
            [$declarations, $dependent] = $this->getSpecialRules($specification, $property);

            $ruleDeclarations[] = $declarations;
            if (!empty($dependent)) {
                $dependentRules[] = $dependent;
            }
        }

        $specialRules = Block::fromArray($ruleDeclarations);

        if (!empty($dependentRules)) {
            $specialRules->addCode(
                $this->wrapDependentRules(
                    $dependentRules,
                    $this->guessSingularModelVariableName($specification->getModel()->getName())
                )
            );
        }

        return $specialRules;
    }

    protected function getSpecialProperties(CrudlySpecification $specification): Collection
    {
        return $specification->getProperties()->filter(function (ModelPropertySpecification $property) {
            return $this->propertyRequiresSpecialRules($property);
        });
    }

    protected function getSpecialRules(CrudlySpecification $specification, ModelPropertySpecification $property): array
    {
        $modelName = $this->guessSingularModelVariableName($specification->getModel()->getName());
        $modelTable = $this->guessTableName($specification->getModel());
        $ruleDeclarations = [];
        $dependentRules = [];

        if ($property->isForeignKey()) {
            $foreignKeySpecification = $property->getForeignKeySpecification();

            $ruleDeclarations[] = $this->getForeignKeyRuleDeclaration(
                $property->getName(),
                $foreignKeySpecification->getForeignKeyTable(),
                $foreignKeySpecification->getForeignKeyField()
            );
        }

        if ($property->isUnique()) {
            $ruleDeclarations[] = $this->getUniqueRuleDeclaration($modelTable, $property->getName());

            $dependentRules[] = $this->getUniqueDependentRule(
                $modelName,
                $property->getName(),
                $specification->getPrimaryKey()->getName()
            );
        }

        $ruleDeclarations = Block::fromArray($ruleDeclarations);
        $dependentRules = (empty($dependentRules)) ? null : Block::fromArray($dependentRules);

        return [$ruleDeclarations, $dependentRules];
    }

    protected function getForeignKeyRuleDeclaration(string $propertyName, string $foreignKeyTable, string $foreignKeyColumn): Code
    {
        return Block::assign(
            $this->getForeignKeyRuleVariable($propertyName),
            Block::invokeStaticMethod(
                new Importable(Rule::class),
                'exists',
                [$foreignKeyTable, $foreignKeyColumn]
            )
        );
    }

    protected function getUniqueRuleDeclaration(string $tableName, string $propertyName): Code
    {
        return Block::assign(
            $this->getUniqueRuleVariable($propertyName),
            Block::invokeStaticMethod(
                Reference::classReference(new Importable(Rule::class)),
                'unique',
                [
                    $tableName,
                    $propertyName
                ]
            )
        );
    }

    protected function getUniqueDependentRule(string $modelName, string $propertyName, string $primaryKeyName): Code
    {
        return Block::invokeMethod(
            $this->getUniqueRuleVariable($propertyName),
            'ignore',
            [
                Reference::objectProperty(
                    Reference::variable($modelName),
                    $primaryKeyName
                )
            ]
        );
    }

    protected function wrapDependentRules(array $rules, string $modelName): Block
    {
        $modelVar = Reference::variable($modelName);

        return Block::fromArray([
            Block::assign(
                $modelVar,
                Block::invokeMethod(Reference::this(), 'route', [$modelName])
            ),
            Block::if($modelVar)->then(Block::fromArray($rules))
        ]);
    }

    protected function guessTableName(ModelName $model): string
    {
        return Str::of($model->getName())->plural()->snake();
    }
}
