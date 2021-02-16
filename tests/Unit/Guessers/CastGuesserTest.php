<?php

namespace Shomisha\Crudly\Test\Unit\Guessers;

use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\CastGuesser;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class CastGuesserTest extends TestCase
{
    public function propertyCastsDataProvider()
    {
        return [
            "Boolean" => [
                PropertySpecificationBuilder::new('is_active', ModelPropertyType::BOOL())->buildSpecification(),
                "boolean",
            ],
            "String" => [
                PropertySpecificationBuilder::new('name', ModelPropertyType::STRING())->buildSpecification(),
                null,
            ],
            "Email" => [
                PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->buildSpecification(),
                null,
            ],
            "Text" => [
                PropertySpecificationBuilder::new('biography', ModelPropertyType::TEXT())->buildSpecification(),
                null,
            ],
            "Integer" => [
                PropertySpecificationBuilder::new('awards_count', ModelPropertyType::INT())->buildSpecification(),
                null,
            ],
            "Big integer" => [
                PropertySpecificationBuilder::new('id', ModelPropertyType::BIG_INT())->buildSpecification(),
                null,
            ],
            "Tiny integer" => [
                PropertySpecificationBuilder::new('alcohol_percentage', ModelPropertyType::TINY_INT())->buildSpecification(),
                null,
            ],
            "Float" => [
                PropertySpecificationBuilder::new('liters_per_package', ModelPropertyType::FLOAT())->buildSpecification(),
                null,
            ],
            "Date" => [
                PropertySpecificationBuilder::new('birth_date', ModelPropertyType::DATE())->buildSpecification(),
                "date",
            ],
            "Datetime" =>[
                PropertySpecificationBuilder::new('last_active_at', ModelPropertyType::DATETIME())->buildSpecification(),
                "datetime",
            ],
            "Timestamp" => [
                PropertySpecificationBuilder::new('last_active_at', ModelPropertyType::TIMESTAMP())->buildSpecification(),
                "datetime",
            ],
            "JSON" => [
                PropertySpecificationBuilder::new('published_books', ModelPropertyType::JSON())->buildSpecification(),
                "array",
            ],
        ];
    }

    /**
     * @test
     * @dataProvider propertyCastsDataProvider
     */
    public function guesser_can_guess_casts_for_model_properties(ModelPropertySpecification $property, $expectedCast)
    {
        $guesser = new CastGuesser();


        $actualCast = $guesser->guess($property);


        $this->assertEquals($expectedCast, $actualCast);
    }
}
