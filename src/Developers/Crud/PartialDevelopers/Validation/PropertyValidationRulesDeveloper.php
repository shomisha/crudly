<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Validation;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ValidationRules;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\Values\Value;

class PropertyValidationRulesDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\ModelPropertySpecification $propertySpecification */
    public function develop(Specification $propertySpecification, CrudlySet $developedSet): Code
    {
        $rules = $this->guessFieldValidationRules($propertySpecification);

        return Value::array(
            $rules->getRules()
        );
    }

    protected function guessFieldValidationRules(ModelPropertySpecification $property): ValidationRules
    {
        $rules = ValidationRules::new();

        if ($property->isNullable()) {
            $rules->nullable();
        } else {
            $rules->required();
        }

        switch ($property->getType()) {
            case ModelPropertyType::BOOL():
                $rules->boolean();
                break;
            case ModelPropertyType::STRING():
                // TODO: make max configurable?
                $rules->string()->max(255);
                break;
            case ModelPropertyType::EMAIL():
                $rules->email();
                break;
            case ModelPropertyType::TEXT():
                $rules->string()->max(65535);
                break;
            case ModelPropertyType::INT():
            case ModelPropertyType::BIG_INT():
                $rules->integer();
                break;
            case ModelPropertyType::TINY_INT():
                // TODO: account for signed and unsigned
                $rules->integer()->max(127);
                break;
            case ModelPropertyType::FLOAT():
                $rules->numeric();
                break;
            case ModelPropertyType::DATE():
                $rules->date();
                break;
            case ModelPropertyType::TIMESTAMP():
            case ModelPropertyType::DATETIME():
                // TODO: make this configurable
                $rules->dateFormat('Y-m-d H:i:s');
                break;
            case ModelPropertyType::JSON():
                $rules->array();
                break;
        }

        return $rules;
    }
}
