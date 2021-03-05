<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Factory;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Factory\CreateMultipleModelInstances;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class CreateMultipleModelInstancesDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_creating_multiple_new_model_instances_using_factory()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new CreateMultipleModelInstances($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);

        $printedBlock = $block->print();
        $this->assertStringContainsString("use App\Models\Post;", $printedBlock);
        $this->assertStringContainsString("\$posts = Post::factory()->count(5)->create();", $printedBlock);
    }
}
