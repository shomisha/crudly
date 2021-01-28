<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\Validation;

use Shomisha\Crudly\Contracts\ModelSupervisor;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ValidationRules;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Crudly\ModelPropertyGuessers\ValidationRulesGuesser;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Stubless\Values\ArrayValue;
use Shomisha\Stubless\Values\Value;

class PropertyValidationRulesDeveloper extends CrudDeveloper
{
    private ValidationRulesGuesser $ruleGuesser;

    public function __construct(DeveloperManagerAbstract $manager, ModelSupervisor $modelSupervisor, ValidationRulesGuesser $ruleGuesser)
    {
        parent::__construct($manager, $modelSupervisor);

        $this->ruleGuesser = $ruleGuesser;
    }

    /** @param \Shomisha\Crudly\Specifications\ModelPropertySpecification $propertySpecification */
    public function develop(Specification $propertySpecification, CrudlySet $developedSet): ArrayValue
    {
        $rules = $this->guessFieldValidationRules($propertySpecification);

        return Value::array(
            $rules->getRules()
        );
    }

    protected function guessFieldValidationRules(ModelPropertySpecification $property): ValidationRules
    {
        if ($property->isNullable()) {
            $rules = ValidationRules::new()->nullable();
        } else {
            $rules = ValidationRules::new()->required();
        }

        $this->ruleGuesser->withRules($rules)->guess($property);

        return $rules;
    }
}
