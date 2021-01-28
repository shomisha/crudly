<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults;

use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

abstract class DefaultsGuesser
{
    public static function new(): self
    {
        return new static();
    }

    public function canGuessDefaultFor(ModelPropertySpecification $property): bool
    {
        if ($property->getType() === ModelPropertyType::EMAIL()) {
            return true;
        }

        return array_key_exists($property->getName(), $this->getDefaults());
    }

    public function guessDefaultFor(ModelPropertySpecification $property)
    {
        if ($this->propertyIsEmail($property)) {
            return $this->getEmailDefault();
        }

        return $this->getDefaults()[$property->getName()] ?? null;
    }

    protected function propertyIsEmail(ModelPropertySpecification $property): bool
    {
        return $property->getType() === ModelPropertyType::EMAIL();
    }

    abstract protected function getDefaults(): array;

    abstract protected function getEmailDefault(): string;
}
