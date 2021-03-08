<?php

namespace Shomisha\Crudly\Developers\Crud\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\GetModelDataSpecialDefaultsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class GetModelDataSpecialDefaultsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_model_special_data_defaults()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Article')
            ->property('id', ModelPropertyType::BIG_INT())
            ->property('title', ModelPropertyType::STRING())
            ->property('body', ModelPropertyType::TEXT())
            ->property('author_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'authors')
            ->property('category_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'categories');

        $this->modelSupervisor->expectedExistingModels(['Category']);


        $developer = new GetModelDataSpecialDefaultsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "if (!array_key_exists('author_id', \$override)) {",
            "    throw IncompleteTestException::provideMissingForeignKey('author_id');",
            "}",
            "if (!array_key_exists('category_uuid', \$override)) {",
            "    \$override['category_uuid'] = Category::factory()->create()->uuid;",
            "}",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_develop_using_factory_method_if_related_model_exists()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Flight')
            ->property('id', ModelPropertyType::BIG_INT())
            ->property('number', ModelPropertyType::STRING())
            ->property('takeoff', ModelPropertyType::DATETIME())
            ->property('pilot_identification_number', ModelPropertyType::BIG_INT())
            ->isForeign('identification_number', 'pilots');

        $this->modelSupervisor->expectedExistingModels(['Pilot']);


        $developer = new GetModelDataSpecialDefaultsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "if (!array_key_exists('pilot_identification_number', \$override)) {",
            "    \$override['pilot_identification_number'] = Pilot::factory()->create()->identification_number;",
            "}",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_develop_throwing_exception_if_related_model_does_not_exist()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Match')
            ->property('id', ModelPropertyType::BIG_INT())
            ->property('league', ModelPropertyType::STRING())
            ->property('players_json', ModelPropertyType::TEXT())
            ->property('hosting_team_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'teams');


        $developer = new GetModelDataSpecialDefaultsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "if (!array_key_exists('hosting_team_uuid', \$override)) {",
            "    throw IncompleteTestException::provideMissingForeignKey('hosting_team_uuid');",
            "}",
        ]), $block->print());
    }
}
