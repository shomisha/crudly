<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillValidatedDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class FillValidatedDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_filling_model_using_validated_request_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new FillValidatedDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);

        $this->assertStringContainsString("\$post->fill(\$request->validated());", $block->print());
    }
}
