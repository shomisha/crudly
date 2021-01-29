<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\ObjectContainer;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeBlock;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\ObjectProperty;
use Shomisha\Stubless\References\Reference;

class FakerMethodGuesser extends ModelPropertyGuesser
{
    private ObjectContainer $faker;

    public function __construct(ObjectContainer $faker)
    {
        $this->faker = $faker;
    }

    protected function guessForBoolean(ModelPropertySpecification $property): ObjectProperty
    {
        return $this->appendPropertyToFaker('boolean');
    }

    protected function guessForString(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('text', [255]);
    }

    protected function guessForEmail(ModelPropertySpecification $property): ObjectProperty
    {
        return $this->appendPropertyToFaker('email');
    }

    protected function guessForText(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('text', [63000]);
    }

    protected function guessForInteger(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('randomNumber');
    }

    protected function guessForBigInteger(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('randomNumber');
    }

    protected function guessForTinyInteger(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('numberBetween', [1, 32000]);
    }

    protected function guessForFloat(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('randomFloat');
    }

    protected function guessForDate(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('date');
    }

    protected function guessForTimestamp(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('dateTime');
    }

    protected function guessForDatetime(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('dateTime');
    }

    protected function guessForJson(ModelPropertySpecification $property): InvokeBlock
    {
        return $this->appendInvocationToFaker('shuffleArray', [[1, 2, 3, 'test', 'another', true]]);
    }

    protected function appendInvocationToFaker(string $method, array $arguments = []): InvokeBlock
    {
        if ($this->faker instanceof InvokeMethodBlock) {
            return $this->faker->chain($method, $arguments);
        }

        return Block::invokeMethod($this->faker, $method, $arguments);
    }

    protected function appendPropertyToFaker(string $property): ObjectProperty
    {
        return Reference::objectProperty($this->faker, $property);
    }
}
