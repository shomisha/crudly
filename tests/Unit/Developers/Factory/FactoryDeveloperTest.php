<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Factory;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Factory\FactoryClassDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\FactoryDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class FactoryDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_factory_class()
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


        $manager = new FactoryDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new FactoryClassDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $factory = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(ClassTemplate::class, $factory);
        $this->assertEquals($factory, $developedSet->getFactory());

        $printedFactory = $factory->print();

        $this->assertStringContainsString("use Illuminate\Database\Eloquent\Factories\Factory;", $printedFactory);
        $this->assertStringContainsString("use Illuminate\Support\Facades\DB;", $printedFactory);
        $this->assertStringContainsString("use App\Models\Post;", $printedFactory);
        $this->assertStringContainsString("use App\Models\Author;", $printedFactory);

        $this->assertStringContainsString(implode("\n", [
            "class PostFactory extends Factory",
            "{",
            "    protected \$model = Post::class;\n",
            "    public function definition()",
            "    {",
            "        return ['title' => \$this->faker->text(255), 'body' => \$this->faker->text(63000), 'author_id' => function (\$arguments) {",
            "            return Author::query()->inRandomOrder()->first()->id;",
            "        }, 'category_id' => function (\$arguments) {",
            "            return DB::table('categories')->inRandomOrder()->first()->id;",
            "        }];",
            "    }",
            "}",
        ]), $printedFactory);
    }

    /** @test */
    public function developer_will_delegate_model_property_and_definition_method_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');

        $this->manager->propertyDevelopers(['getFactoryModelPropertyDeveloper'])
                      ->methodDevelopers(['getDefinitionMethodDeveloper']);


        $developer = new FactoryClassDeveloper($this->manager, $this->modelSupervisor);
        $factory = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassTemplate::class, $factory);

        $this->manager->assertPropertyDeveloperRequested('getFactoryModelPropertyDeveloper');
        $this->manager->assertMethodDeveloperRequested('getDefinitionMethodDeveloper');
    }
}
