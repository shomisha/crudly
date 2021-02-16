<?php

namespace Shomisha\Crudly\Test\Unit\Guessers;

use Shomisha\Crudly\Data\ValidationRules;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\ValidationRulesGuesser;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class ValidationRulesGuesserTest extends TestCase
{
    public function modelPropertyDataProvider()
    {
        return [
            'Boolean' => [
                PropertySpecificationBuilder::new('someBoolean', ModelPropertyType::BOOL())->buildSpecification(),
                ['boolean'],
            ],
            'String' => [
                PropertySpecificationBuilder::new('someString', ModelPropertyType::STRING())->buildSpecification(),
                ['string', 'max:255'],
            ],
            'Email' => [
                PropertySpecificationBuilder::new('someEmail', ModelPropertyType::EMAIL())->buildSpecification(),
                ['email'],
            ],
            'Text' => [
                PropertySpecificationBuilder::new('someText', ModelPropertyType::TEXT())->buildSpecification(),
                ['string', 'max:65535'],
            ],
            'Integer' => [
                PropertySpecificationBuilder::new('someInteger', ModelPropertyType::INT())->buildSpecification(),
                ['integer'],
            ],
            'Big integer' => [
                PropertySpecificationBuilder::new('someBigInteger', ModelPropertyType::BIG_INT())->buildSpecification(),
                ['integer'],
            ],
            'TinyInteger' => [
                PropertySpecificationBuilder::new('someTinyInteger', ModelPropertyType::TINY_INT())->buildSpecification(),
                ['integer'],
            ],
            'Float' => [
                PropertySpecificationBuilder::new('someFloat', ModelPropertyType::FLOAT())->buildSpecification(),
                ['numeric'],
            ],
            'Date' => [
                PropertySpecificationBuilder::new('someDate', ModelPropertyType::DATE())->buildSpecification(),
                ['date']
            ],
            'Datetime' => [
                PropertySpecificationBuilder::new('someDatetime', ModelPropertyType::DATETIME())->buildSpecification(),
                ['date_format:Y-m-d H:i:s']
            ],
            'Timestamp' => [
                PropertySpecificationBuilder::new('someTimestamp', ModelPropertyType::TIMESTAMP())->buildSpecification(),
                ['date_format:Y-m-d H:i:s']
            ],
            'Json' => [
                PropertySpecificationBuilder::new('someJson', ModelPropertyType::JSON())->buildSpecification(),
                ['array']
            ],
        ];
    }

    /**
     * @test
     * @dataProvider modelPropertyDataProvider
     */
    public function guesser_can_guess_validation_rules_for_model_property(ModelPropertySpecification $property, array $expectedRules)
    {
        $guesser = new ValidationRulesGuesser();


        $actualRules = $guesser->guess($property);


        $this->assertInstanceOf(ValidationRules::class, $actualRules);
        $this->assertEquals($expectedRules, $actualRules->getRules());
    }

    /** @test */
    public function guesser_can_append_property_rules_to_existing_ones()
    {
        $propertyBuilder = PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->unique();

        $guesser = new ValidationRulesGuesser();


        $rules = new ValidationRules([
            'unique' => true,
            'string' => true,
        ]);
        $guesser->withRules($rules);
        $guesser->guess($propertyBuilder->buildSpecification());


        $this->assertEquals([
            'unique', 'string', 'email',
        ], $rules->getRules());
    }
}
