<?php

namespace Shomisha\Crudly\Test\Unit\Guessers;

use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\InvalidValidationDataProvidersGuesser;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class InvalidValidationDataProviderGuesserTest extends TestCase
{
    public function modelPropertyDataProvider()
    {
        return [
            'Boolean' => [
                PropertySpecificationBuilder::new('someBoolean', ModelPropertyType::BOOL())->nullable()->buildSpecification(),
                [
                    "Some boolean is not a boolean" => ["someBoolean", "not a boolean"],
                ],
            ],
            'String' => [
                PropertySpecificationBuilder::new('someString', ModelPropertyType::STRING())->nullable()->buildSpecification(),
                [
                    "Some string is not a string" => ["someString", false],
                ],
            ],
            'Email' => [
                PropertySpecificationBuilder::new('randomEmail', ModelPropertyType::EMAIL())->nullable()->buildSpecification(),
                [
                    "Random email is not an email" => ["randomEmail", "not an email"],
                ],
            ],
            'Text' => [
                PropertySpecificationBuilder::new('really_long_Text', ModelPropertyType::TEXT())->nullable()->buildSpecification(),
                [
                    "Really long text is not a string" => ["really_long_Text", 124],
                ]
            ],
            'Integer' => [
                PropertySpecificationBuilder::new('BigBigNumber', ModelPropertyType::INT())->nullable()->buildSpecification(),
                [
                    "Big big number is not an integer" => ["BigBigNumber", "not an integer"],
                ],
            ],
            'Big integer' => [
                PropertySpecificationBuilder::new('Even_biggerInteger', ModelPropertyType::BIG_INT())->nullable()->buildSpecification(),
                [
                    "Even bigger integer is not an integer" => ["Even_biggerInteger", "not an integer"],
                ],
            ],
            'Tiny integer' => [
                PropertySpecificationBuilder::new('poccito_integer', ModelPropertyType::TINY_INT())->nullable()->buildSpecification(),
                [
                    "Poccito integer is not an integer" => ["poccito_integer", "not an integer"],
                ],
            ],
            'Float' => [
                PropertySpecificationBuilder::new('floatito', ModelPropertyType::FLOAT())->nullable()->buildSpecification(),
                [
                    "Floatito is not numeric" => ["floatito", "not numeric"]
                ],
            ],
            'Date' => [
                PropertySpecificationBuilder::new('birth_date', ModelPropertyType::DATE())->nullable()->buildSpecification(),
                [
                    "Birth date is not a date" => ["birth_date", "not a date"],
                ],
            ],
            'Datetime' => [
                PropertySpecificationBuilder::new('published_At', ModelPropertyType::DATETIME())->nullable()->buildSpecification(),
                [
                    "Published at is not a date" => ["published_At", "not a date"],
                    "Published at is in invalid format" => ["published_At", "21.12.2012. at 21:12"],
                ],
            ],
            'Timestamp' => [
                PropertySpecificationBuilder::new('created_at', ModelPropertyType::TIMESTAMP())->nullable()->buildSpecification(),
                [
                    "Created at is not a date" => ["created_at", "not a date"],
                    "Created at is in invalid format" => ["created_at", "21.12.2012. at 21:12"],
                ],
            ],
            'Json' => [
                PropertySpecificationBuilder::new('lucky_numbers', ModelPropertyType::JSON())->nullable()->buildSpecification(),
                [
                    "Lucky numbers is not an array" => ["lucky_numbers", "not an array"],
                ]
            ],
        ];
    }

    /**
     * @test
     * @dataProvider modelPropertyDataProvider
     */
    public function guesser_will_guess_invalid_validation_data_provider_entries_for_property(ModelPropertySpecification $property, array $expectedDataProviderEntries)
    {
        $guesser = new InvalidValidationDataProvidersGuesser();


        $actualDataProviderEntries = $guesser->guess($property);


        $this->assertEquals($expectedDataProviderEntries, $actualDataProviderEntries);
    }

    /** @test */
    public function guesser_can_guess_property_missing_entries_for_required_properties()
    {
        $guesser = new InvalidValidationDataProvidersGuesser();

        $propertyBuilder = PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->nullable(false);


        $dataProviderEntries = $guesser->guess($propertyBuilder->buildSpecification());


        $this->assertEquals([
            'Email is not an email' => ['email', 'not an email'],
            'Email is missing' => ['email', null],
        ], $dataProviderEntries);
    }
}
