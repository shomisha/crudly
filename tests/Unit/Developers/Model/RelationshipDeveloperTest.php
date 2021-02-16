<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Model;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Model\RelationshipDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Enums\RelationshipType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class RelationshipDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_add_relationships_to_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->isForeign('id', 'authors')
                ->isRelationship('author', RelationshipType::BELONGS_TO())
            ->property('category_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'categories')
                ->isRelationship('category', RelationshipType::BELONGS_TO())
        ->timestamps(false);

        $model = ClassTemplate::name('Post');
        $this->assertStringNotContainsString('public function author', $model->print());
        $this->assertStringNotContainsString('public function category', $model->print());

        $this->modelSupervisor->expectedExistingModels([
            'Author',
            'Category'
        ]);


        $developer = new RelationshipDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = with(new CrudlySet())->setModel($model);
        $developer->develop($specificationBuilder->build(), $developedSet);


        $printedModel = $model->print();
        $this->assertStringContainsString(implode("\n", [
            "    public function author()",
            "    {",
            "        return \$this->belongsTo(Author::class, 'author_id', 'id');",
            "    }\n",
            "    public function category()",
            "    {",
            "        return \$this->belongsTo(Category::class, 'category_uuid', 'uuid');",
            "    }\n",
        ]), $printedModel);
    }

    /** @test */
    public function developer_will_not_add_relationships_with_inexisting_models()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->isForeign('id', 'authors')
                ->isRelationship('author', RelationshipType::BELONGS_TO())
            ->property('category_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'categories')
                ->isRelationship('category', RelationshipType::BELONGS_TO())
            ->timestamps(false);

        $model = ClassTemplate::name('Post');
        $this->assertStringNotContainsString('public function author', $model->print());
        $this->assertStringNotContainsString('public function category', $model->print());

        $developer = new RelationshipDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = with(new CrudlySet())->setModel($model);
        $developer->develop($specificationBuilder->build(), $developedSet);


        $printedModel = $model->print();
        $this->assertEquals(implode("\n", [
            "<?php\n",
            "class Post",
            "{",
            "}",
        ]), $printedModel);
    }
}
