<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\ModelKeyArgumentDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\Argument;

class ModelPrimaryKeyArgumentDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["Post", "id", "postId"]
     *           ["Author", "uuid", "authorUuid"]
     *           ["User", "email", "userEmail"]
     *           ["Phone", "number", "phoneNumber"]
     *           ["House", "address", "houseAddress"]
     *           ["Product", "Serial", "productSerial"]
     */
    public function developer_will_develop_the_primary_key_argument(string $modelName, string $primaryKeyName, string $expectedArgumentName)
    {
        $specification = CrudlySpecificationBuilder::forModel($modelName)
            ->property($primaryKeyName, ModelPropertyType::STRING())->primary()
        ->build();


        $developer = new ModelKeyArgumentDeveloper($this->manager, $this->modelSupervisor);
        $argument = $developer->develop($specification, new CrudlySet());


        $this->assertInstanceOf(Argument::class, $argument);
        $this->assertStringContainsString($expectedArgumentName, $argument->print());
    }
}
