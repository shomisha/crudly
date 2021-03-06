<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelsMissingSingularModel;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertResponseModelsMissingSingularModelDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_response_models_missing_singular_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Advertisement')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary();


        $developer = new AssertResponseModelsMissingSingularModel($this->manager, $this->modelSupervisor);
        $block  = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertNotContains(\$advertisement->uuid, \$responseAdvertisementIds);", $block->print());
    }
}
