<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers;

use Faker\Factory;
use Faker\Generator;
use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\References\Reference;
use Shomisha\Stubless\Values\ArrayValue;
use Shomisha\Stubless\Values\Value;

class GetModelDataPrimeDefaultsDeveloper extends TestsDeveloper
{
    protected Generator $faker;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, Factory $fakerFactory)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->faker = $fakerFactory->create();
    }

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return Block::invokeFunction(
            'array_merge',
            [
                $this->prepareDefaultValues($specification),
                Reference::variable('override'),
            ]
        );
    }

    protected function prepareDefaultValues(CrudlySpecification $specification): ArrayValue
    {
        return Value::array(
            $specification->getProperties()->mapWithKeys(function (ModelPropertySpecification $property) {
                if ($property->isPrimaryKey() || $property->isForeignKey()) {
                    return [null => null];
                }

                return [
                    $property->getName() => $this->preparePropertyDefaultValue($property),
                ];
            })->filter()->toArray()
        );
    }

    protected function preparePropertyDefaultValue(ModelPropertySpecification $property): Code
    {
        if ($formatter = $this->guessFakerFormatter($property->getName())) {
            $value = $this->faker->{$formatter};
        } else {
            $value = $this->guessValueFromType($property);
        }

        return Value::normalize($value);
    }

    protected function guessFakerFormatter(string $field): ?string
    {
        return [
            'title' => 'title',
            'email' => 'email',
            'name' => 'name',
            'address' => 'address',
            'street' => 'streetName',
        ][$field] ?? null;
    }

    protected function guessValueFromType(ModelPropertySpecification $property)
    {
        switch ($property->getType()) {
            case ModelPropertyType::BOOL():
                return $this->faker->boolean;
            case ModelPropertyType::STRING():
                return $this->faker->sentence;
            case ModelPropertyType::EMAIL():
                return $this->faker->email;
            case ModelPropertyType::TEXT():
                return $this->faker->paragraphs(rand(2, 4), true);
            case ModelPropertyType::INT():
                return $this->faker->numberBetween(1, 32000);
            case ModelPropertyType::BIG_INT():
                return $this->faker->numberBetween(1, 65000);
            case ModelPropertyType::TINY_INT():
                return $this->faker->numberBetween(1, 127);
            case ModelPropertyType::FLOAT():
                return $this->faker->randomFloat();
            case ModelPropertyType::DATE():
                return $this->faker->date();
            case ModelPropertyType::TIMESTAMP():
            case ModelPropertyType::DATETIME():
                return $this->faker->dateTime;
            case ModelPropertyType::JSON():
                return $this->faker->shuffleArray([1, 2, 3, 'test', 'another']);
        }
    }
}
