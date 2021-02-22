<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\InvokeModelMethodDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\Comparisons\Comparison;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;
use Shomisha\Stubless\References\Reference;

class InvokeModelMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_model_method_invocation()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Employee');


        $developer = new InvokeModelMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->using([
            'method' => 'doSomething',
            'arguments' => [1, 'string', true],
        ]);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$employee->doSomething(1, 'string', true);", $block->print());

        $this->assertEmpty($block->getDelegatedImports());
    }

    /** @test */
    public function developer_can_develop_model_method_invocation_using_custom_model_variable()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $developer = new InvokeModelMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->using([
            'modelVarName' => 'mainAuthor',
            'method' => 'write',
            'arguments' => ['book'],
        ]);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$mainAuthor->write('book');", $printedBlock);
    }

    public function argumentsDataProvider()
    {
        return [
            'Primitives - integer'            => [1, "1"],
            'Primitives - string'             =>  ['string', "'string'"],
            'Primitives - boolean'            => [true, "true"],
            'Primitives - array'              =>   [[1, 2, 3], "[1, 2, 3]"],
            'Assignable values - reference'   => [Reference::variable('someVar'), "\$someVar"],
            'Assignable values - invocation'  => [Block::invokeFunction('someFunction'), 'someFunction()'],
            'Assignable values - comparisons' => [Comparison::equalsStrict(1, 'first'), "1 === 'first'"],
        ];
    }

    /**
     * @test
     * @dataProvider argumentsDataProvider
     */
    public function user_can_pass_in_primitives_or_assignable_values_as_arguments($argument, string $printedArgument)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Manager');


        $developer = new InvokeModelMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->using([
            'method' => 'doSomething',
            'arguments' => [$argument],
        ]);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$manager->doSomething({$printedArgument})", $printedBlock);
    }
}
