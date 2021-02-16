<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Shomisha\Crudly\Specifications\ModelPropertySpecification;

class CastGuesser extends ModelPropertyGuesser
{
    protected function guessForBoolean(ModelPropertySpecification $property)
    {
        return 'boolean';
    }

    protected function guessForString(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForEmail(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForText(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForInteger(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForBigInteger(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForTinyInteger(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForFloat(ModelPropertySpecification $property)
    {
        return null;
    }

    protected function guessForDate(ModelPropertySpecification $property)
    {
        return 'date';
    }

    protected function guessForTimestamp(ModelPropertySpecification $property)
    {
        return 'datetime';
    }

    protected function guessForDatetime(ModelPropertySpecification $property)
    {
        return 'datetime';
    }

    protected function guessForJson(ModelPropertySpecification $property)
    {
        return 'array';
    }
}
