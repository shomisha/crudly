<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Migrations;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Migration\UpMethodDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\MigrationDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;

class UpMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_migration_up_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('email', ModelPropertyType::EMAIL())->unique()->primary()
            ->property('name', ModelPropertyType::STRING())
            ->softDeletes()
            ->softDeletionColumn('deleted_at')
            ->timestamps(false);


        $manager = new MigrationDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new UpMethodDeveloper($manager, $this->modelSupervisor);
        $upMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $upMethod);

        $printedMethod = $upMethod->print();
        $this->assertStringContainsString("public function up()\n{", $printedMethod);
        $this->assertStringContainsString("Schema::create('authors', function (Blueprint \$table) {\n", $printedMethod);
        $this->assertStringContainsString("\$table->string('email')->unique()->primary();", $printedMethod);
        $this->assertStringContainsString("\$table->string('name');", $printedMethod);
        $this->assertStringContainsString("\$table->softDeletes('deleted_at');", $printedMethod);
        $this->assertStringNotContainsString("\$table->timestamps();", $printedMethod);
    }

    /**
     * @test
     * @testWith ["Post", "posts"]
     *           ["Author", "authors"]
     *           ["User", "users"]
     *           ["Criterium", "criteria"]
     */
    public function developer_can_guess_table_name_based_on_model(string $modelName, string $expectedTableName)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel($modelName)->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary();


        $manager = new MigrationDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new UpMethodDeveloper($manager, $this->modelSupervisor);
        $printedMethod = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringNotContainsString("Schema::create('{$expectedTableName}', function (Blueprint \$table)\n", $printedMethod);
    }

    /** @test */
    public function developer_will_delegate_fields_development_to_other_developer()
    {
        $specification = CrudlySpecificationBuilder::forModel('Author')
            ->property('email', ModelPropertyType::EMAIL())->unique()->primary();


        $this->manager->imperativeCodeDevelopers([
            'getMigrationFieldsDeveloper'
        ]);
        $developer = new UpMethodDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specification->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getMigrationFieldsDeveloper');
    }
}
