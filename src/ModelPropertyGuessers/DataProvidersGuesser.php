<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Shomisha\Crudly\Specifications\ModelPropertySpecification;

class DataProvidersGuesser extends ModelPropertyGuesser
{
    protected function guessForBoolean(ModelPropertySpecification $property)
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not a boolean" => 'not a boolean',
        ]);
    }

    protected function guessForString(ModelPropertySpecification $property)
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not a string" => false,
        ]);
    }

    protected function guessForEmail(ModelPropertySpecification $property)
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not an email" => "not an email",
        ]);
    }

    protected function guessForText(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForText() method.
    }

    protected function guessForInteger(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForInteger() method.
    }

    protected function guessForBigInteger(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForBigInteger() method.
    }

    protected function guessForTinyInteger(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForTinyInteger() method.
    }

    protected function guessForFloat(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForFloat() method.
    }

    protected function guessForDate(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForDate() method.
    }

    protected function guessForTimestamp(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForTimestamp() method.
    }

    protected function guessForDatetime(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForDatetime() method.
    }

    protected function guessForJson(ModelPropertySpecification $property)
    {
        // TODO: Implement guessForJson() method.
    }

    private function potentiallyRequiredProviders(ModelPropertySpecification $property, array $otherProviders): array
    {
        $otherProviders = array_map(fn($provider) => $this->normalizeProvider($property, $provider), $otherProviders);

        if (!$property->isNullable()) {
            $otherProviders["{$this->propertyName($property)} is missing"] = [$property->getName(), null];
        }

        return $otherProviders;
    }

    private function normalizeProvider(ModelPropertySpecification $property, $provider): array
    {
        if (!is_array($provider)) {
            $provider = [$property->getName(), $provider];
        } elseif (count($provider) < 2) {
            array_unshift($provider, $property->getName());
        }

        return $provider;
    }
}
