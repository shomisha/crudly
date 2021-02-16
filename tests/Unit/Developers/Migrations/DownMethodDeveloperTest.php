<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Migrations;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Migration\DownMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;

class DownMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_down_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Store')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary();


        $developer = new DownMethodDeveloper($this->manager, $this->modelSupervisor);
        $downMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $downMethod);

        $printedMethod = $downMethod->print();
        $this->assertStringContainsString("public function down()\n{", $printedMethod);
        $this->assertStringContainsString("Schema::dropIfExists('stores');", $printedMethod);
    }

    /**
     * @test
     * @testWith ["Car", "cars"]
     *           ["Buyer", "buyers"]
     *           ["Employee", "employees"]
     *           ["Rule", "rules"]
     *           ["Idea", "ideas"]
     */
    public function developer_can_guess_table_name(string $modelName, string $expectedTableName)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName)
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary();


        $developer = new DownMethodDeveloper($this->manager, $this->modelSupervisor);
        $printedMethod = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("Schema::dropIfExists('{$expectedTableName}');", $printedMethod);
    }
}
