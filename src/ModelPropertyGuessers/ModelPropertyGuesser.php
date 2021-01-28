<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Illuminate\Support\Str;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

abstract class ModelPropertyGuesser
{
    public function guess(ModelPropertySpecification $property)
    {
        switch ($property->getType()) {
            case ModelPropertyType::BOOL():
                return $this->guessForBoolean($property);
            case ModelPropertyType::STRING():
                return $this->guessForString($property);
            case ModelPropertyType::EMAIL():
                return $this->guessForEmail($property);
            case ModelPropertyType::TEXT():
                return $this->guessForText($property);
            case ModelPropertyType::INT():
                return $this->guessForInteger($property);
            case ModelPropertyType::BIG_INT():
                return $this->guessForBigInteger($property);
            case ModelPropertyType::TINY_INT():
                return $this->guessForTinyInteger($property);
            case ModelPropertyType::FLOAT():
                return $this->guessForFloat($property);
            case ModelPropertyType::DATE():
                return $this->guessForDate($property);
            case ModelPropertyType::TIMESTAMP():
                return $this->guessForTimestamp($property);
            case ModelPropertyType::DATETIME():
                return $this->guessForDatetime($property);
            case ModelPropertyType::JSON():
                return $this->guessForJson($property);
        };
    }

    abstract protected function guessForBoolean(ModelPropertySpecification $property);

    abstract protected function guessForString(ModelPropertySpecification $property);

    abstract protected function guessForEmail(ModelPropertySpecification $property);

    abstract protected function guessForText(ModelPropertySpecification $property);

    abstract protected function guessForInteger(ModelPropertySpecification $property);

    abstract protected function guessForBigInteger(ModelPropertySpecification $property);

    abstract protected function guessForTinyInteger(ModelPropertySpecification $property);

    abstract protected function guessForFloat(ModelPropertySpecification $property);

    abstract protected function guessForDate(ModelPropertySpecification $property);

    abstract protected function guessForTimestamp(ModelPropertySpecification $property);

    abstract protected function guessForDatetime(ModelPropertySpecification $property);

    abstract protected function guessForJson(ModelPropertySpecification $property);

    protected function propertyName(ModelPropertySpecification $property): string
    {
        return Str::of($property->getName())->camel()->snake(' ')->ucfirst();
    }
}
