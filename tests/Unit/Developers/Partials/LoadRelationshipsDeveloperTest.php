<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\LoadRelationshipsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class LoadRelationshipsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_implement_loading_relationships_for_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author')
            ->property('category_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'categories')
            ->property('sponsor_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'sponsors')
                ->isRelationship('sponsor');

        $this->modelSupervisor->expectedExistingModels([
            'Author',
            'Category'
        ]);


        $developer = new LoadRelationshipsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $this->assertStringContainsString("\$post->load(['author']);", $block->print());
    }

    /** @test */
    public function developer_will_not_load_non_relationship_foreign_keys()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('category_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'categories');

        $this->modelSupervisor->expectedExistingModels([
            'Category'
        ]);


        $developer = new LoadRelationshipsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);

        $this->assertStringNotContainsString("\$post->load", $block->print());
    }

    /** @test */
    public function developer_will_not_load_non_existing_relationships()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
                ->isRelationship('author');

        $this->modelSupervisor->expectedExistingModels([]);


        $developer = new LoadRelationshipsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringNotContainsString("\$post->load", $block->print());
    }
}
