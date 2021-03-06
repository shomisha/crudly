<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelIsJsonModel;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertModelIsJsonModelDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_model_is_json_response_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Manager')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary();


        $developer = new AssertModelIsJsonModel($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$responseManagerId = \$response->json('data.id');",
            "\$this->assertEquals(\$manager->id, \$responseManagerId);",
        ]), $block->print());
    }
}
