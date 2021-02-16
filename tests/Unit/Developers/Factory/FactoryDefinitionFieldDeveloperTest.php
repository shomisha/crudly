<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Factory;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Factory\FactoryDefinitionFieldDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Specification\PropertySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;

class FactoryDefinitionFieldDeveloperTest extends DeveloperTestCase
{
    public function modelPropertyDataProvider()
    {
        return [
            'Boolean' => [
                PropertySpecificationBuilder::new('someBoolean', ModelPropertyType::BOOL())->buildSpecification(),
                "\$this->faker->boolean;",
            ],
            'String' => [
                PropertySpecificationBuilder::new('someString', ModelPropertyType::STRING())->buildSpecification(),
                "\$this->faker->text(255);",
            ],
            'Email' => [
                PropertySpecificationBuilder::new('someEmail', ModelPropertyType::EMAIL())->buildSpecification(),
                "\$this->faker->email;",
            ],
            'Text' => [
                PropertySpecificationBuilder::new('someText', ModelPropertyType::TEXT())->buildSpecification(),
                "\$this->faker->text(63000);",
            ],
            'Integer' => [
                PropertySpecificationBuilder::new('someInteger', ModelPropertyType::INT())->buildSpecification(),
                "\$this->faker->randomNumber();",
            ],
            'Big integer' => [
                PropertySpecificationBuilder::new('someBigInteger', ModelPropertyType::BIG_INT())->buildSpecification(),
                "\$this->faker->randomNumber();",
            ],
            'TinyInteger' => [
                PropertySpecificationBuilder::new('someTinyInteger', ModelPropertyType::TINY_INT())->buildSpecification(),
                "\$this->faker->numberBetween(1, 32000);",
            ],
            'Float' => [
                PropertySpecificationBuilder::new('someFloat', ModelPropertyType::FLOAT())->buildSpecification(),
                "\$this->faker->randomFloat();",
            ],
            'Date' => [
                PropertySpecificationBuilder::new('someDate', ModelPropertyType::DATE())->buildSpecification(),
                "\$this->faker->date();",
            ],
            'Datetime' => [
                PropertySpecificationBuilder::new('someDatetime', ModelPropertyType::DATETIME())->buildSpecification(),
                "\$this->faker->dateTime();",
            ],
            'Timestamp' => [
                PropertySpecificationBuilder::new('someTimestamp', ModelPropertyType::TIMESTAMP())->buildSpecification(),
                "\$this->faker->dateTime();",
           ],
            'Json' => [
                PropertySpecificationBuilder::new('someJson', ModelPropertyType::JSON())->buildSpecification(),
                "\$this->faker->shuffleArray([1, 2, 3, 'test', 'another', true]);",
            ],
        ];
    }

    /**
     * @test
     * @dataProvider modelPropertyDataProvider
     */
    public function developer_will_develop_factory_field_for_model_property(ModelPropertySpecification $property, string $printedProperty)
    {
        $developer = new FactoryDefinitionFieldDeveloper($this->manager, $this->modelSupervisor);


        $field = $developer->develop($property, new CrudlySet());


        $this->assertStringContainsString($printedProperty, $field->print());
    }

    /** @test */
    public function developer_can_make_property_factory_fields_unique()
    {
        $propertyBuilder = PropertySpecificationBuilder::new('email', ModelPropertyType::EMAIL())->unique();


        $developer = new FactoryDefinitionFieldDeveloper($this->manager, $this->modelSupervisor);
        $field = $developer->develop($propertyBuilder->buildSpecification(), new CrudlySet());


        $printedField = $field->print();
        $this->assertStringContainsString("\$this->faker->unique()->email;", $printedField);
    }

    /** @test */
    public function developer_will_develop_factory_field_for_foreign_keys()
    {
        $propertyBuilder = PropertySpecificationBuilder::new('author_id', ModelPropertyType::BIG_INT())
            ->unsigned()
            ->isForeign('id', 'authors');


        $developer = new FactoryDefinitionFieldDeveloper($this->manager, $this->modelSupervisor);
        $field = $developer->develop($propertyBuilder->buildSpecification(), new CrudlySet());


        $printedField = $field->print();
        $this->assertStringContainsString("use Illuminate\Support\Facades\DB;", $printedField);
        $this->assertStringContainsString(implode("\n", [
            "function (\$arguments) {",
            "    return DB::table('authors')->inRandomOrder()->first()->id;",
            "};",
        ]), $field->print());
    }

    /** @test */
    public function developer_will_load_the_property_specified_as_target_for_foreign_key_if_related_model_does_not_exist()
    {
        $propertyBuilder = PropertySpecificationBuilder::new('author_email', ModelPropertyType::BIG_INT())
           ->unsigned()
           ->isForeign('email', 'authors');


        $developer = new FactoryDefinitionFieldDeveloper($this->manager, $this->modelSupervisor);
        $field = $developer->develop($propertyBuilder->buildSpecification(), new CrudlySet());


        $printedField = $field->print();
        $this->assertStringContainsString("use Illuminate\Support\Facades\DB;", $printedField);
        $this->assertStringContainsString(implode("\n", [
            "function (\$arguments) {",
            "    return DB::table('authors')->inRandomOrder()->first()->email;",
            "};",
        ]), $field->print());
    }

    /** @test */
    public function developer_will_load_related_model_using_eloquent_if_model_exists()
    {
        $propertyBuilder = PropertySpecificationBuilder::new('author_uuid', ModelPropertyType::BIG_INT())
                                                       ->unsigned()
                                                       ->isForeign('uuid', 'authors')
                                                       ->isRelationship('author');

        $this->modelSupervisor->expectedExistingModels(['Author']);


        $developer = new FactoryDefinitionFieldDeveloper($this->manager, $this->modelSupervisor);
        $field = $developer->develop($propertyBuilder->buildSpecification(), new CrudlySet());


        $printedField = $field->print();
        $this->assertStringContainsString("use App\Models\Author;", $printedField);
        $this->assertStringContainsString(implode("\n", [
            "function (\$arguments) {",
            "    return Author::query()->inRandomOrder()->first()->uuid;",
            "};",
        ]), $printedField);
    }

    /** @test */
    public function developer_will_use_related_model_factory_for_factory_field_if_it_exists()
    {
        $propertyBuilder = PropertySpecificationBuilder::new('author_id', ModelPropertyType::BIG_INT())
            ->unsigned()
            ->isForeign('id', 'authors')
            ->isRelationship('author');

        $this->modelSupervisor->expectedExistingModels(['Author']);


        $developer = \Mockery::mock(
            FactoryDefinitionFieldDeveloper::class . "[factoryExists]",
            [$this->manager, $this->modelSupervisor]
        )->shouldAllowMockingProtectedMethods();
        $developer->expects('factoryExists')->withAnyArgs()->andReturnTrue();
        $field = $developer->develop($propertyBuilder->buildSpecification(), new CrudlySet());


        $printedField = $field->print();
        $this->assertStringContainsString("Author::factory();", $printedField);
    }
}
