<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Faker\Generator;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

class PrimeDefaultGuesser extends ModelPropertyGuesser
{
    private Generator $faker;

    public function __construct(Generator $faker)
    {
        $this->faker = $faker;
    }

    protected function guessForBoolean(ModelPropertySpecification $property): bool
    {
        return $this->faker->boolean;
    }

    protected function guessForString(ModelPropertySpecification $property): string
    {
        return $this->faker->sentence;
    }

    protected function guessForEmail(ModelPropertySpecification $property): string
    {
        return $this->faker->email;
    }

    protected function guessForText(ModelPropertySpecification $property): string
    {
        return $this->faker->paragraphs(rand(2, 4), true);
    }

    protected function guessForInteger(ModelPropertySpecification $property): int
    {
        return $this->faker->randomNumber();
    }

    protected function guessForBigInteger(ModelPropertySpecification $property): int
    {
        return $this->faker->randomNumber();
    }

    protected function guessForTinyInteger(ModelPropertySpecification $property): int
    {
        return $this->faker->numberBetween(1, 32000);
    }

    protected function guessForFloat(ModelPropertySpecification $property): float
    {
        return $this->faker->randomFloat();
    }

    protected function guessForDate(ModelPropertySpecification $property): string
    {
        return $this->faker->date();
    }

    protected function guessForTimestamp(ModelPropertySpecification $property): string
    {
        return $this->faker->dateTime()->format('Y-m-d H:i:s');
    }

    protected function guessForDatetime(ModelPropertySpecification $property): string
    {
        return $this->faker->dateTime()->format('Y-m-d H:i:s');
    }

    protected function guessForJson(ModelPropertySpecification $property): array
    {
        return $this->faker->shuffleArray([1, 2, 3, 'test', 'another', true]);
    }
}
