<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertDatabaseHasModelDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertDatabaseHasModelDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_database_contains_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Speaker')
            ->property('topic', ModelPropertyType::STRING())
                ->primary();


        $developer = new AssertDatabaseHasModelDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertDatabaseHas('speakers', ['topic' => \$speaker->topic]);", $block->print());
    }
}
