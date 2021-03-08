<?php

namespace Shomisha\Crudly\Developers\Crud\Tests\HelperMethodDevelopers;

use Faker\Factory;
use Faker\Generator;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataPrimeDefaultsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\ReturnBlock;

class GetModelDataPrimeDefaultsDeveloperTest extends DeveloperTestCase
{
    private function getFakerFactoryMock(array $fields): Factory
    {
        $factoryMock = \Mockery::mock(Factory::class);

        $generator = \Mockery::mock(Generator::class);
        $factoryMock->shouldReceive('create')->andReturn($generator);


        foreach ($fields as $formatter => $value) {
            $generator->{$formatter} = $value;
        }

        return $factoryMock;
    }

    /** @test */
    public function developer_can_develop_getting_model_data_prime_defaults()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('User')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('restaurant_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'restaurants');

        $faker = $this->getFakerFactoryMock([
            'name' => 'Jonathan Gray',
            'email' => 'jgray@test.com'
        ]);


        $developer = new GetModelDataPrimeDefaultsDeveloper($this->manager, $this->modelSupervisor, $faker);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ReturnBlock::class, $block);
        $this->assertStringContainsString(
            "array_merge(['name' => 'Jonathan Gray', 'email' => 'jgray@test.com'], \$override);",
            $block->print()
        );
    }

    /** @test */
    public function developer_will_use_old_defaults_guesser_if_an_unknown_field_exists()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('User')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('nickname', ModelPropertyType::STRING());

        $faker = $this->getFakerFactoryMock([
            'sentence' => 'Johnny Boy',
        ]);


        $developer = new GetModelDataPrimeDefaultsDeveloper($this->manager, $this->modelSupervisor, $faker);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertStringContainsString("array_merge(['nickname' => 'Johnny Boy'], \$override);", $block->print());
    }
}
