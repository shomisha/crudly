<?php

namespace Shomisha\Crudly\Test\Unit\Guessers;

use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\FakerMethodGuesser;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;
use Shomisha\Stubless\References\Reference;

class FactoryFieldGuesserTest extends TestCase
{
    public function modelPropertyDataProvider()
    {
        return [
            'Boolean' => [
                PropertySpecificationBuilder::new('someBoolean', ModelPropertyType::BOOL())->buildSpecification(),
                "\$faker->boolean;",
            ],
            'String' => [
                PropertySpecificationBuilder::new('someString', ModelPropertyType::STRING())->buildSpecification(),
                "\$faker->text(255);",
            ],
            'Email' => [
                PropertySpecificationBuilder::new('someEmail', ModelPropertyType::EMAIL())->buildSpecification(),
                "\$faker->email;",
            ],
            'Text' => [
                PropertySpecificationBuilder::new('someText', ModelPropertyType::TEXT())->buildSpecification(),
                "\$faker->text(63000);",
            ],
            'Integer' => [
                PropertySpecificationBuilder::new('someInteger', ModelPropertyType::INT())->buildSpecification(),
                "\$faker->randomNumber();",
            ],
            'Big integer' => [
                PropertySpecificationBuilder::new('someBigInteger', ModelPropertyType::BIG_INT())->buildSpecification(),
                "\$faker->randomNumber();",
            ],
            'TinyInteger' => [
                PropertySpecificationBuilder::new('someTinyInteger', ModelPropertyType::TINY_INT())->buildSpecification(),
                "\$faker->numberBetween(1, 32000);",
            ],
            'Float' => [
                PropertySpecificationBuilder::new('someFloat', ModelPropertyType::FLOAT())->buildSpecification(),
                "\$faker->randomFloat();",
            ],
            'Date' => [
                PropertySpecificationBuilder::new('someDate', ModelPropertyType::DATE())->buildSpecification(),
                "\$faker->date();",
            ],
            'Datetime' => [
                PropertySpecificationBuilder::new('someDatetime', ModelPropertyType::DATETIME())->buildSpecification(),
                "\$faker->dateTime();",
            ],
            'Timestamp' => [
                PropertySpecificationBuilder::new('someTimestamp', ModelPropertyType::TIMESTAMP())->buildSpecification(),
                "\$faker->dateTime();",
            ],
            'Json' => [
                PropertySpecificationBuilder::new('someJson', ModelPropertyType::JSON())->buildSpecification(),
                "\$faker->shuffleArray([1, 2, 3, 'test', 'another', true]);",
            ],
        ];
    }

    /**
     * @test
     * @dataProvider modelPropertyDataProvider
     */
    public function guesser_will_guess_factory_field_for_property(ModelPropertySpecification $property, string $expectedPrintedProperty)
    {
        $faker = Reference::variable('faker');
        $guesser = new FakerMethodGuesser($faker);


        $actualPrintedProperty = $guesser->guess($property)->print();


        $this->assertStringContainsString($expectedPrintedProperty, $actualPrintedProperty);
    }
}
