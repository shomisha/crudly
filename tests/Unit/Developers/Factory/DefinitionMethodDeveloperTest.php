<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Factory;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Factory\DefinitionMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\FactoryDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class DefinitionMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_implement_the_definition_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
          ->property('id', ModelPropertyType::BIG_INT())->primary()
          ->property('title', ModelPropertyType::STRING())
          ->property('body', ModelPropertyType::TEXT())
          ->property('author_id', ModelPropertyType::BIG_INT())
              ->unsigned()
              ->isForeign('id', 'authors')
              ->isRelationship('author')
          ->property('category_id', ModelPropertyType::BIG_INT())
              ->unsigned()
              ->isForeign('id', 'categories');

        $this->modelSupervisor->expectedExistingModels(['Author']);


        $manager = new FactoryDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DefinitionMethodDeveloper($manager, $this->modelSupervisor);
        $definitionMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $definitionMethod);
        $this->assertEquals('App\Models\Author', $definitionMethod->getDelegatedImports()['App\Models\Author']->getName());

        $factoryClass = ClassTemplate::name('Factory')->addMethod($definitionMethod);
        $printedMethod = $factoryClass->print();
        $this->assertStringContainsString(implode("\n", [
            "    public function definition()",
            "    {",
            "        return ['title' => \$this->faker->text(255), 'body' => \$this->faker->text(63000), 'author_id' => function (\$arguments) {",
            "            return Author::query()->inRandomOrder()->first()->id;",
            "        }, 'category_id' => function (\$arguments) {",
            "            return DB::table('categories')->inRandomOrder()->first()->id;",
            "        }];",
            "    }",
        ]), $printedMethod);
    }

    /** @test */
    public function definition_will_not_include_primary_keys_and_auto_increment_fields()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
          ->property('id', ModelPropertyType::BIG_INT())->primary()
          ->property('likes', ModelPropertyType::BIG_INT())->autoIncrement()
          ->property('title', ModelPropertyType::STRING());

        $this->modelSupervisor->expectedExistingModels(['Author']);


        $manager = new FactoryDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DefinitionMethodDeveloper($manager, $this->modelSupervisor);
        $definitionMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $printedMethod = $definitionMethod->print();
        $this->assertStringNotContainsString("'id' => \$this->faker->randomNumber()", $printedMethod);
        $this->assertStringNotContainsString("'likes' => \$this->faker->randomNumber()", $printedMethod);
        $this->assertStringContainsString("'title' => \$this->faker->text(255)", $printedMethod);
    }

    /** @test */
    public function developer_will_delegate_property_definitions_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('title', ModelPropertyType::STRING());

        $this->manager->valueDevelopers(['getFactoryDefinitionFieldDeveloper']);


        $developer = new DefinitionMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getFactoryDefinitionFieldDeveloper');
    }
}
