<?php

namespace Shomisha\Crudly\Test\Unit\Guessers;

use Carbon\CarbonImmutable;
use Faker\Generator;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\ModelPropertyGuessers\PrimeDefaultGuesser;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class PrimeDefaultGuesserTest extends TestCase
{
    public function modelPropertyDataProvider()
    {
        return [
            'Boolean' => [
                PropertySpecificationBuilder::new('someBoolean', ModelPropertyType::BOOL())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsBool($actualDefault);
                },
            ],
            'String' => [
                PropertySpecificationBuilder::new('someString', ModelPropertyType::STRING())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsString($actualDefault);
                    $this->assertTrue(strlen($actualDefault) <= 255);
                },
            ],
            'Email' => [
                PropertySpecificationBuilder::new('someEmail', ModelPropertyType::EMAIL())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsString($actualDefault);
                    $this->assertNotFalse(filter_var($actualDefault, FILTER_VALIDATE_EMAIL));
                },
            ],
            'Text' => [
                PropertySpecificationBuilder::new('someText', ModelPropertyType::TEXT())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsString($actualDefault);
                    $this->assertTrue(strlen($actualDefault) <= 65000);
                },
            ],
            'Integer' => [
                PropertySpecificationBuilder::new('someInteger', ModelPropertyType::INT())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsInt($actualDefault);
                },
            ],
            'Big integer' => [
                PropertySpecificationBuilder::new('someBigInteger', ModelPropertyType::BIG_INT())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsInt($actualDefault);
                },
            ],
            'TinyInteger' => [
                PropertySpecificationBuilder::new('someTinyInteger', ModelPropertyType::TINY_INT())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsInt($actualDefault);
                },
            ],
            'Float' => [
                PropertySpecificationBuilder::new('someFloat', ModelPropertyType::FLOAT())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertIsFloat($actualDefault);
                },
            ],
            'Date' => [
                PropertySpecificationBuilder::new('someDate', ModelPropertyType::DATE())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertEquals(
                        CarbonImmutable::createFromFormat('Y-m-d', $actualDefault)->format('Y-m-d'),
                        $actualDefault
                    );
                },
            ],
            'Datetime' => [
                PropertySpecificationBuilder::new('someDatetime', ModelPropertyType::DATETIME())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertEquals(
                        CarbonImmutable::createFromFormat('Y-m-d H:i:s', $actualDefault)->format('Y-m-d H:i:s'),
                        $actualDefault
                    );
                },
            ],
            'Timestamp' => [
                PropertySpecificationBuilder::new('someTimestamp', ModelPropertyType::TIMESTAMP())->buildSpecification(),
                function ($actualDefault) {
                    $this->assertEquals(
                        CarbonImmutable::createFromFormat('Y-m-d H:i:s', $actualDefault)->format('Y-m-d H:i:s'),
                        $actualDefault
                    );
                },
            ],
            'Json' => [
                PropertySpecificationBuilder::new('someJson', ModelPropertyType::JSON())->buildSpecification(),
                function ($actualDefault) {
                    $expectedElements = [1, 2, 3, 'test', 'another', true];

                    foreach ($expectedElements as $element) {
                        $this->assertContains($element, $actualDefault);
                    }

                    $this->assertNotEquals($expectedElements, $actualDefault);
                    $this->assertCount(count($expectedElements), $actualDefault);
                },
            ],
        ];
    }

    /**
     * @test
     * @dataProvider modelPropertyDataProvider
     */
    public function guesser_will_guess_prime_defaults_for_properties(ModelPropertySpecification $property, callable $assertions)
    {
        $guesser = new PrimeDefaultGuesser($this->app->get(Generator::class));


        $primeDefault = $guesser->guess($property);


        $assertions($primeDefault);
    }
}
