<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Migrations;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Migration\MigrationDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\MigrationDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class MigrationDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_build_migration_class()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('email', ModelPropertyType::EMAIL())->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('published_books', ModelPropertyType::INT())->unsigned()->nullable()
            ->property('is_active', ModelPropertyType::BOOL())
            ->property('published_book_titles', ModelPropertyType::JSON())->nullable()
            ->timestamps()
            ->softDeletes()
            ->softDeletionColumn('stopped_writing_at');


        $manager = new MigrationDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new MigrationDeveloper($manager, $this->modelSupervisor);
        $developedClass = $developer->develop($specificationBuilder->build(), $developedSet = new CrudlySet());


        $this->assertInstanceOf(ClassTemplate::class, $developedClass);
        $this->assertEquals($developedClass, $developedSet->getMigration());

        $printedClass = $developedClass->print();
        $this->assertStringContainsString('use Illuminate\Database\Migrations\Migration;', $printedClass);
        $this->assertStringContainsString('class CreateAuthorsTable extends Migration', $printedClass );

        $this->assertStringContainsString('use Illuminate\Support\Facades\Schema;', $printedClass);
        $this->assertStringContainsString('use Illuminate\Database\Schema\Blueprint;', $printedClass);

        $this->assertStringContainsString("public function up()\n    {", $printedClass);
        $this->assertStringContainsString("Schema::create('authors', function (Blueprint \$table) {\n", $printedClass);

        $this->assertStringContainsString('$table->id();', $printedClass);
        $this->assertStringContainsString("\$table->string('email')->unique();", $printedClass);
        $this->assertStringContainsString("\$table->string('name');", $printedClass);
        $this->assertStringContainsString("\$table->integer('published_books')->nullable()->unsigned();", $printedClass);
        $this->assertStringContainsString("\$table->boolean('is_active');", $printedClass);
        $this->assertStringContainsString("\$table->json('published_book_titles')->nullable();", $printedClass);
        $this->assertStringContainsString("\$table->softDeletes('stopped_writing_at');", $printedClass);
        $this->assertStringContainsString("\$table->timestamps();", $printedClass);

        $this->assertStringContainsString("public function down()\n    {", $printedClass);
        $this->assertStringContainsString("Schema::dropIfExists('authors');", $printedClass);
    }

    /** @test */
    public function developer_will_delegate_method_development_to_other_developers()
    {
        $specification = CrudlySpecificationBuilder::forModel('Post')->build();

        $methodDevelopers = [
            'getMigrationUpMethodDeveloper',
            'getMigrationDownMethodDeveloper',
        ];
        $this->manager->methodDevelopers($methodDevelopers);


        $developer = new MigrationDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specification, new CrudlySet());


        $this->manager->assertMethodDeveloperRequested('getMigrationUpMethodDeveloper');
        $this->manager->assertMethodDeveloperRequested('getMigrationDownMethodDeveloper');
    }
}
