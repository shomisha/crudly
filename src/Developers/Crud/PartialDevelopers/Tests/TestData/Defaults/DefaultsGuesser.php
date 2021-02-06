<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults;

use Illuminate\Support\Collection;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

abstract class DefaultsGuesser
{
    private Collection $properties;

    public function __construct(Collection $properties)
    {
        $this->properties = $properties;
    }

    public static function forProperties(Collection $properties): self
    {
        return new static($properties);
    }

    public function guess(): array
    {
        return $this->properties->mapWithKeys(function (ModelPropertySpecification $property) {
            if ($this->canGuessDefaultFor($property)) {
                return [$property->getName() => $this->guessDefaultFor($property)];
            }

            return [null => null];
        })->filter()->toArray();
    }

    protected function canGuessDefaultFor(ModelPropertySpecification $property): bool
    {
        if ($this->propertyIsEmail($property)) {
            return true;
        }

        return array_key_exists($property->getName(), $this->getDefaults());
    }

    protected function guessDefaultFor(ModelPropertySpecification $property)
    {
        if ($this->propertyIsEmail($property)) {
            return $this->getEmailDefault();
        }

        return $this->getDefaults()[$property->getName()] ?? null;
    }

    protected function propertyIsEmail(ModelPropertySpecification $property): bool
    {
        return $property->getType() == ModelPropertyType::EMAIL();
    }

    abstract protected function getDefaults(): array;

    abstract protected function getEmailDefault(): string;
}
