<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Validation\PropertyValidationRulesDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\ValidationRulesGuesser;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\Values\ArrayValue;

class PropertyValidationRulesDeveloperTest extends DeveloperTestCase
{
    public function propertyDataProvider()
    {
        return [
            'UUID' => [
                PropertySpecificationBuilder::new('uuid', ModelPropertyType::STRING())->primary(),
                "['required', 'string', 'max:255'];",
            ],
            'Email' => [
                PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->unique(),
                "['required', 'email'];",
            ],
            'String' => [
                PropertySpecificationBuilder::new('name', ModelPropertyType::STRING()),
                "['required', 'string', 'max:255'];",
            ],
            'Date' => [
                PropertySpecificationBuilder::new('birth_date', ModelPropertyType::DATE())->nullable(),
                "['nullable', 'date'];",
            ],
            'Boolean' => [
                PropertySpecificationBuilder::new('is_active', ModelPropertyType::BOOL()),
                "['required', 'boolean'];",
            ],
            'Integer' => [
                PropertySpecificationBuilder::new('total_friends', ModelPropertyType::INT()),
                "['required', 'integer'];",
            ],
            'JSON' =>[
                PropertySpecificationBuilder::new('friends', ModelPropertyType::JSON()),
                "['required', 'array'];",
            ],
        ];
    }

    /**
     * @test
     * @dataProvider propertyDataProvider
     */
    public function developer_will_develop_property_validation_rules(PropertySpecificationBuilder $specificationBuilder, string $printedRules)
    {
        $property = $specificationBuilder->buildSpecification();


        $developer = new PropertyValidationRulesDeveloper($this->manager, $this->modelSupervisor, new ValidationRulesGuesser());
        $rules = $developer->develop($property, new CrudlySet());


        $this->assertInstanceOf(ArrayValue::class, $rules);
        $this->assertStringContainsString($printedRules, $rules->print());
    }
}
