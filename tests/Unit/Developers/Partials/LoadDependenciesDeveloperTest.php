<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadDependenciesDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class LoadDependenciesDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_loading_relationship_dependencies()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('id', ModelPropertyType::BIG_INT())
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
            ->property('category_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'categories')
                ->isRelationship('category')
            ->property('sponsor_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'sponsors')
                ->isRelationship('sponsor');

        $this->modelSupervisor->expectedExistingModels([
            'Author', 'Category',
        ]);


        $developer = new LoadDependenciesDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);

        $printedBlock = $block->print();
        $this->assertStringContainsString("use App\Models\Category;", $printedBlock);
        $this->assertStringContainsString("use App\Models\Author;", $printedBlock);
        $this->assertStringContainsString("use Illuminate\Support\Facades\DB;", $printedBlock);
        $this->assertStringContainsString(implode("\n", [
            "\$authors = Author::all();",
            "\$categories = Category::all();",
            "\$sponsors = DB::table('sponsors')->get();",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_load_dependencies_using_eloquent_if_model_exists()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('country_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'countries');

        $this->modelSupervisor->expectedExistingModels([
            'Country'
        ]);


        $developer = new LoadDependenciesDeveloper($this->manager, $this->modelSupervisor);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("use App\Models\Country;", $printedBlock);
        $this->assertStringContainsString("\$countries = Country::all();", $printedBlock);
    }

    /** @test */
    public function developer_will_load_dependencies_straight_from_database_if_model_does_not_exist()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Car')
            ->property('manufacturer_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'manufacturers');

        $this->modelSupervisor->expectedExistingModels([]);


        $developer = new LoadDependenciesDeveloper($this->manager, $this->modelSupervisor);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("use Illuminate\Support\Facades\DB;", $printedBlock);
        $this->assertStringContainsString("\$manufacturers = DB::table('manufacturers')->get();", $printedBlock);

        $this->assertStringNotContainsString("use App\Models\Manufacturer;", $printedBlock);
        $this->assertStringNotContainsString("Manufacturer::all()", $printedBlock);
    }
}
