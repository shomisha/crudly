<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertAllModelIdsPresentDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertAllModelIdsPresentDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_all_model_ids_are_present_in_response()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Building')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary();


        $developer = new AssertAllModelIdsPresentDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "foreach (\$buildings as \$building) {",
            "    \$this->assertContains(\$building->uuid, \$responseBuildingIds);",
            "}"
        ]), $block->print());
    }
}
