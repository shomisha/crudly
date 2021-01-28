<?php

namespace Shomisha\Crudly\ModelPropertyGuessers;

use Shomisha\Crudly\Data\ValidationRules;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;

class ValidationRulesGuesser extends ModelPropertyGuesser
{
    private ?ValidationRules $existingRules = null;

    public function withRules(ValidationRules $existingRules): self
    {
        $this->existingRules = $existingRules;

        return $this;
    }

    protected function guessForBoolean(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->boolean();
    }

    protected function guessForString(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->string()->max(255);
    }

    protected function guessForEmail(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->email();
    }

    protected function guessForText(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->string()->max(65535);
    }

    protected function guessForInteger(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->integer();
    }

    protected function guessForBigInteger(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->integer();
    }

    protected function guessForTinyInteger(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->integer();
    }

    protected function guessForFloat(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->numeric();
    }

    protected function guessForDate(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->date();
    }

    protected function guessForTimestamp(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->dateFormat('Y-m-d H:i:s');
    }

    protected function guessForDatetime(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->dateFormat('Y-m-d H:i:s');
    }

    protected function guessForJson(ModelPropertySpecification $property): ValidationRules
    {
        return $this->getRules()->array();
    }

    private function getRules(): ValidationRules
    {
        return $this->existingRules ?? ValidationRules::new();
    }
}
