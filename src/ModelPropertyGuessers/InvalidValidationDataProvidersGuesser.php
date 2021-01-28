<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Shomisha\Crudly\Specifications\ModelPropertySpecification;

class InvalidValidationDataProvidersGuesser extends ModelPropertyGuesser
{
    protected function guessForBoolean(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not a boolean" => 'not a boolean',
        ]);
    }

    protected function guessForString(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not a string" => false,
        ]);
    }

    protected function guessForEmail(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not an email" => "not an email",
        ]);
    }

    protected function guessForText(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not a string" => 124,
        ]);
    }

    protected function guessForInteger(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not an integer" => "not an integer",
        ]);
    }

    protected function guessForBigInteger(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not an integer" => "not an integer",
        ]);
    }

    protected function guessForTinyInteger(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not an integer" => "not an integer",
        ]);
    }

    protected function guessForFloat(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not numeric" => "not numeric",
        ]);
    }

    protected function guessForDate(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not a date" => "not a date",
        ]);
    }

    protected function guessForTimestamp(ModelPropertySpecification $property): array
    {
        $propertyName = $this->propertyName($property);

        return $this->potentiallyRequiredProviders($property, [
            "{$propertyName} is not a date" => "not a date",
            "{$propertyName} is in invalid format" => "21.12.2012. at 21:12",
        ]);
    }

    protected function guessForDatetime(ModelPropertySpecification $property): array
    {
        $propertyName = $this->propertyName($property);

        return $this->potentiallyRequiredProviders($property, [
            "{$propertyName} is not a date" => "not a date",
            "{$propertyName} is in invalid format" => "21.12.2012. at 21:12",
        ]);
    }

    protected function guessForJson(ModelPropertySpecification $property): array
    {
        return $this->potentiallyRequiredProviders($property, [
            "{$this->propertyName($property)} is not an array" => "not an array",
        ]);
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
