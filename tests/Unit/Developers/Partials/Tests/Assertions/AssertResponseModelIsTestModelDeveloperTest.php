<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertResponseModelIsTestModel;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertResponseModelIsTestModelDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_response_model_is_test_model()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $developer = new AssertResponseModelIsTestModel($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$responseAuthor = \$response->viewData('author');",
            "\$this->assertTrue(\$author->is(\$responseAuthor));",
        ]), $block->print());
    }
}
