<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ImplicitBindArgumentsDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\Argument;

class ImplicitBindArgumentsDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["Post", "post"]
     *           ["Author", "author"]
     *           ["Car", "car"]
     *           ["Idea", "idea"]
     *           ["Criterium", "criterium"]
     */
    public function developer_will_develop_a_model_implicit_bind_argument(string $modelName, string $expectedArgumentName)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName);


        $developer = new ImplicitBindArgumentsDeveloper($this->manager, $this->modelSupervisor);
        $argument = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Argument::class, $argument);
        $this->assertEquals($expectedArgumentName, $argument->getName());
        $this->assertEquals($modelName, $argument->getType());

        $this->assertModelIncludedInCode($modelName, $argument);
    }
}
