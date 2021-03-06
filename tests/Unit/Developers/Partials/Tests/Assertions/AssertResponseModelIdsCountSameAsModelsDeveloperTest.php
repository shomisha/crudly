<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIdsCountSameAsModels;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertResponseModelIdsCountSameAsModelsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_response_model_ids_count_is_equal_to_models_count()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new AssertResponseModelIdsCountSameAsModels($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertCount(\$posts->count(), \$responsePostIds);", $block->print());
    }
}
