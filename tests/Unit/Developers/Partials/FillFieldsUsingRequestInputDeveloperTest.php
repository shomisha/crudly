<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\Web\Store\Fill\FillFieldUsingRequestInputDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class FillFieldsUsingRequestInputDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_filling_fields_using_request_input()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new FillFieldUsingRequestInputDeveloper($this->manager, $this->modelSupervisor);
        $developer->using(['property' => 'title']);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$post->title = \$request->input('title');", $block->print());
    }

    /** @test */
    public function developer_can_accept_model_and_response_variable_names_as_parameters()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new FillFieldUsingRequestInputDeveloper($this->manager, $this->modelSupervisor);
        $developer->using([
            'property' => 'title',
            'requestVarName' => 'someRequest',
            'modelVarName' => 'headlinerPost'
        ]);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$headlinerPost->title = \$someRequest->input('title');", $printedBlock);
    }
}
