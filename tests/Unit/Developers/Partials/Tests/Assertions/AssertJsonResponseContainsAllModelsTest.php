<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertJsonResponseContainsAllModels;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertJsonResponseContainsAllModelsTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_json_response_has_all_models()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Racer')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary();


        $developer = new AssertJsonResponseContainsAllModels($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "foreach (\$racers as \$racer) {",
            "    \$this->assertContains(\$racer->id, \$responseRacerIds);",
            "}",
        ]), $block->print());
    }
}
