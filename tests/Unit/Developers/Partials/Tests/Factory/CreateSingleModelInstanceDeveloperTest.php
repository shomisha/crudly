<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Factory;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateSingleModelInstance;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class CreateSingleModelInstanceDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_creating_a_single_model_instance_using_factory()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new CreateSingleModelInstance($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);

        $printedBlock = $block->print();
        $this->assertStringContainsString("use App\Models\Post;", $printedBlock);
        $this->assertStringContainsString("\$post = Post::factory()->create();", $printedBlock);
    }
}
