<?php

namespace Shomisha\Crudly\Test\Unit\DefaultsGuessers;

use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\Defaults\NewDefaults;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class NewDefaultsTest extends TestCase
{
    /** @test */
    public function guesser_can_guess_new_defaults()
    {
        $properties = [
            PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->buildSpecification(),
            PropertySpecificationBuilder::new('title', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('name', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('description', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('body', ModelPropertyType::STRING())->buildSpecification(),
            PropertySpecificationBuilder::new('address', ModelPropertyType::STRING())->buildSpecification(),
        ];


        $defaults = NewDefaults::forProperties(collect($properties))->guess();


        $this->assertEquals([
            'email' => 'new@test.com',
            'title' => 'New Title',
            'name' => 'New Name',
            'description' => 'New Description',
            'body' => 'New Body',
            'address' => 'New Street 10, New City, New Country',
        ], $defaults);
    }
}
