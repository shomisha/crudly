<?php

namespace Shomisha\Crudly\Test\Unit\DefaultsGuessers;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\OldDefaults;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class OldDefaultsTest extends TestCase
{
    /** @test */
    public function guesser_will_guess_old_defaults()
    {
        $properties = [
            PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->buildSpecification(),
            PropertySpecificationBuilder::new('title', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('name', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('description', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('body', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('address', ModelPropertyType::STRING())->buildSpecification(),
        ];


        $defaults = OldDefaults::forProperties(collect($properties))->guess();


        $this->assertEquals([
            'email' => 'old@test.com',
            'title' => 'Old Title',
            'name' => 'Old Name',
            'description' => 'Old Description',
            'body' => 'Old Body',
            'address' => 'Old Street 15, Old City, Old Country',
        ], $defaults);
    }
}
