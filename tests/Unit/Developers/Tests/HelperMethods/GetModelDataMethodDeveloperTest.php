<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\HelperMethods;

use Faker\Factory;
use Faker\Generator;
use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\WebTestsDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class GetModelDataMethodDeveloperTest extends DeveloperTestCase
{
    private function mockFakerGenerator(array $fields): Generator
    {
        $factoryMock = \Mockery::mock(Factory::class);

        $generator = \Mockery::mock(Generator::class);
        $factoryMock->shouldReceive('create')->andReturn($generator);


        foreach ($fields as $formatter => $value) {
            $generator->{$formatter} = $value;
        }

        $this->app->instance(Factory::class, $factoryMock);

        return $generator;
    }

    /** @test */
    public function developer_can_develop_the_get_model_data_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('address', ModelPropertyType::STRING())
            ->property('club_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'clubs')
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers');

        $this->modelSupervisor->expectedExistingModels(['Club']);

        $this->mockFakerGenerator([
            'name' => 'David Beckham',
            'email' => 'david@beckham.com',
            'address' => 'Some Street In England 25, London, UK'
        ]);


        $manager = new WebTestsDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new GetModelDataMethodDeveloper($manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $method);
        $this->assertStringContainsString(implode("\n", [
            "    private function getPlayerData(array \$override = []) : array",
            "    {",
            "        if (!array_key_exists('club_uuid', \$override)) {",
            "            \$override['club_uuid'] = Club::factory()->create()->uuid;",
            "        }",
            "        if (!array_key_exists('manager_id', \$override)) {",
            "            throw IncompleteTestException::provideMissingForeignKey('manager_id');",
            "        }\n",

            "        return array_merge(['name' => 'David Beckham', 'email' => 'david@beckham.com', 'address' => 'Some Street In England 25, London, UK'], \$override);",
            "    }",
        ]), ClassTemplate::name('Test')->addMethod($method)->print());
    }

    /** @test */
    public function developer_will_delegate_developing_special_and_prime_fields_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Manager');

        $this->manager->imperativeCodeDevelopers(['getModelDataSpecialDefaultsDeveloper', 'getModelDataPrimeDefaultsDeveloper']);


        $developer = new GetModelDataMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getModelDataSpecialDefaultsDeveloper');
        $this->manager->assertCodeDeveloperRequested('getModelDataPrimeDefaultsDeveloper');
    }
}
