<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Migrations;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Migration\MigrationFieldsDeveloper;
use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class MigrationFieldsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_develop_definitions_for_all_available_fields()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Employee')
            ->property('employee_id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('email', ModelPropertyType::EMAIL())->unique()
            ->property('name', ModelPropertyType::STRING())
            ->property('hire_date', ModelPropertyType::DATE())
            ->property('mentor_id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->nullable()
                ->isForeign('employee_id', 'employees')
                ->isRelationship('mentor')
            ->property('department_id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->isForeign('id', 'departments', ForeignKeyAction::CASCADE(), ForeignKeyAction::SET_NULL())
                ->isRelationship('department')
            ->softDeletes()
            ->softDeletionColumn('fired_at')
            ->timestamps();


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $fields = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $fields);

        $printedFields = $fields->print();
        $this->assertStringContainsString("\$table->id('employee_id');", $printedFields);
        $this->assertStringContainsString("\$table->string('email')->unique();", $printedFields);
        $this->assertStringContainsString("\$table->string('name');", $printedFields);
        $this->assertStringContainsString("\$table->date('hire_date');", $printedFields);
        $this->assertStringContainsString("\$table->bigInteger('mentor_id')->nullable()->unsigned();", $printedFields);
        $this->assertStringContainsString("\$table->bigInteger('department_id')->unsigned();", $printedFields);
        $this->assertStringContainsString("\$table->softDeletes('fired_at');", $printedFields);
        $this->assertStringContainsString("\$table->timestamps();", $printedFields);

        $this->assertStringContainsString("\$table->foreign('mentor_id')->references('employee_id')->on('employees')->onDelete('do nothing')->onUpdate('do nothing');", $printedFields);
        $this->assertStringContainsString("\$table->foreign('department_id')->references('id')->on('departments')->onDelete('set null')->onUpdate('cascade');", $printedFields);
    }

    public function propertyDefinitionDataProvider()
    {
        return [
            "Boolean" => [
                CrudlySpecificationBuilder::forModel('Author')->property('is_active', ModelPropertyType::BOOL())->build(),
                "\$table->boolean('is_active');"
            ],
            "String" => [
                CrudlySpecificationBuilder::forModel('Author')->property('name', ModelPropertyType::STRING())->build(),
                "\$table->string('name');"
            ],
            "Email" => [
                CrudlySpecificationBuilder::forModel('Author')->property('email', ModelPropertyType::EMAIL())->build(),
                "\$table->string('email');"
            ],
            "Text" => [
                CrudlySpecificationBuilder::forModel('Author')->property('biography', ModelPropertyType::TEXT())->build(),
                "\$table->text('biography');"
            ],
            "Integer" => [
                CrudlySpecificationBuilder::forModel('Author')->property('awards_count', ModelPropertyType::INT())->build(),
                "\$table->integer('awards_count');"
            ],
            "Big integer" => [
                CrudlySpecificationBuilder::forModel('Author')->property('id', ModelPropertyType::BIG_INT())->build(),
                "\$table->bigInteger('id');"
            ],
            "Tiny integer" => [
                CrudlySpecificationBuilder::forModel('Beverage')->property('alcohol_percentage', ModelPropertyType::TINY_INT())->build(),
                "\$table->tinyInteger('alcohol_percentage');"
            ],
            "Float" => [
                CrudlySpecificationBuilder::forModel('Beverage')->property('liters_per_package', ModelPropertyType::FLOAT())->build(),
                "\$table->float('liters_per_package');"
            ],
            "Date" => [
                CrudlySpecificationBuilder::forModel('Author')->property('birth_date', ModelPropertyType::DATE())->build(),
                "\$table->date('birth_date');"
            ],
            "Datetime" =>[
                CrudlySpecificationBuilder::forModel('Author')->property('last_active_at', ModelPropertyType::DATETIME())->build(),
                "\$table->dateTime('last_active_at');"
            ],
            "Timestamp" => [
                CrudlySpecificationBuilder::forModel('Author')->property('last_active_at', ModelPropertyType::TIMESTAMP())->build(),
                "\$table->timestamp('last_active_at');"
            ],
            "JSON" => [
                CrudlySpecificationBuilder::forModel('Author')->property('published_books', ModelPropertyType::JSON())->build(),
                "\$table->json('published_books');"
            ],
        ];
    }

    /**
     * @test
     * @dataProvider propertyDefinitionDataProvider
     */
    public function developer_can_develop_migration_field_definitions(CrudlySpecification $specification, string $expectedFieldDefinition)
    {
        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);


        $printedDefinitions = $developer->develop($specification, new CrudlySet())->print();


        $this->assertStringContainsString($expectedFieldDefinition, $printedDefinitions);
    }

    /** @test */
    public function developer_will_develop_primary_key_first()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('age', ModelPropertyType::TINY_INT())
                ->unsigned()
            ->property('id', ModelPropertyType::BIG_INT())
                ->unsigned()
                ->primary()
            ->property('birth_date', ModelPropertyType::DATE())
            ->timestamps(false);


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printedFields = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertEquals(
"<?php

\$table->id();
\$table->string('name');
\$table->string('email')->unique();
\$table->tinyInteger('age')->unsigned();
\$table->date('birth_date');", $printedFields);
    }

    /** @test */
    public function developer_will_develop_soft_deletion_field()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->softDeletes()
            ->softDeletionColumn('fired_at');


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printedFields = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$table->softDeletes('fired_at');", $printedFields);
    }

    /** @test */
    public function developer_will_not_develop_soft_deletion_field_if_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->softDeletes(false);


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printedFields = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringNotContainsString("\$table->softDeletes", $printedFields);
    }

    /** @test */
    public function developer_will_not_develop_soft_deletion_column_if_no_name_is_specified()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->softDeletes(true);


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printed = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringNotContainsString("\$table->softDeletes", $printed);
    }

    /** @test */
    public function developer_will_develop_timestamps_fields()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->timestamps(true);


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printedFields = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$table->timestamps();", $printedFields);
    }

    /** @test */
    public function developer_will_not_develop_timestamp_fields_if_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
                                                          ->timestamps(false);


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printedFields = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringNotContainsString("\$table->timestamps", $printedFields);
    }

    /** @test */
    public function developer_will_develop_foreign_key_definitions()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Purchase')
            ->property('id', ModelPropertyType::BIG_INT())->unsigned()->primary()
            ->property('product_id', ModelPropertyType::BIG_INT())->unsigned()
                ->isForeign('id', 'products', ForeignKeyAction::DO_NOTHING(), ForeignKeyAction::CASCADE())
            ->property('buyer_email', ModelPropertyType::EMAIL())
                ->isForeign('email', 'users', ForeignKeyAction::DO_NOTHING(), ForeignKeyAction::SET_NULL())
            ->property('seller_id', ModelPropertyType::BIG_INT())->unsigned()
                ->isForeign('id', 'sellers')
            ->timestamps(false);


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printedFields = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString(
            "\$table->bigInteger('product_id')->unsigned();\n" .
                   "\$table->string('buyer_email');\n" .
                   "\$table->bigInteger('seller_id')->unsigned();\n" .
                   "\$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('do nothing');\n" .
                   "\$table->foreign('buyer_email')->references('email')->on('users')->onDelete('set null')->onUpdate('do nothing');\n" .
                   "\$table->foreign('seller_id')->references('id')->on('sellers')->onDelete('do nothing')->onUpdate('do nothing');",
            $printedFields
        );
    }

    /** @test */
    public function developer_can_make_fields_unsigned()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Human')
            ->property('age', ModelPropertyType::TINY_INT())->unsigned();


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printed = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$table->tinyInteger('age')->unsigned();", $printed);
    }

    public function nonNumericFieldsDataProvider()
    {
        return [
            "Boolean" => [ModelPropertyType::BOOL()],
            "String" => [ModelPropertyType::STRING()],
            "Email" => [ModelPropertyType::EMAIL()],
            "Text" => [ModelPropertyType::TEXT()],
            "Date" => [ModelPropertyType::DATE()],
            "Datetime" => [ModelPropertyType::DATETIME()],
            "Timestamp" => [ModelPropertyType::TIMESTAMP()],
            "JSON" => [ModelPropertyType::JSON()],
        ];
    }

    /**
     * @test
     * @dataProvider nonNumericFieldsDataProvider
     */
    public function developer_cannot_make_non_numeric_fields_unsigned(ModelPropertyType $type)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('someProperty', $type)->unsigned();


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printed = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringNotContainsString('->unsigned()', $printed);
    }

    /** @test */
    public function developer_can_make_fields_nullable()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property('published_at', ModelPropertyType::DATETIME())->nullable();


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printed = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$table->dateTime('published_at')->nullable();", $printed);
    }

    /** @test */
    public function developer_can_make_fields_unique()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('User')
            ->property('email', ModelPropertyType::EMAIL())->unique();


        $developer = new MigrationFieldsDeveloper($this->manager, $this->modelSupervisor);
        $printed = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString("\$table->string('email')->unique();", $printed);
    }
}
