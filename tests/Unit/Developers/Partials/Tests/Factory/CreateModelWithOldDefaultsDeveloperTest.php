<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Factory;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateModelWithOldDefaultsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class CreateModelWithOldDefaultsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_creating_model_instance_with_old_defaults()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('email', ModelPropertyType::EMAIL())
            ->property('name', ModelPropertyType::STRING());



        $developer = new CreateModelWithOldDefaultsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$author = Author::factory()->create(['email' => 'old@test.com', 'name' => 'Old Name']);", $block->print());
    }
}
