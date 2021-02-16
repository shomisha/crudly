<?php

namespace Shomisha\Crudly\Test\Unit;

use Illuminate\Support\Collection;
use Shomisha\Crudly\Commands\CrudlyWizard;
use Shomisha\Crudly\Contracts\ModelSupervisor as ModelSupervisorContract;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Mocks\Crudly;
use Shomisha\Crudly\Test\TestCase;

class WizardTest extends TestCase
{
    private Crudly $crudly;

    protected function getEnvironmentSetUp($app)
    {
        $this->crudly = new Crudly($app->get(ModelSupervisorContract::class));

        $app->bind(CrudlyWizard::class, function ($app) {
            return new CrudlyWizard($this->crudly);
        });
    }

    /** @test */
    public function wizard_will_gather_information_from_user()
    {
        // TODO: extractuj pokretanje wizarda u neko metodu
        $this->artisan('crudly:model')
            ->expectsQuestion('Enter the name of your model', 'Post')

            ->expectsOutput('Define model properties:')
            ->expectsQuestion('Enter property name', 'id')
            ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unsigned?', 'yes')
            ->expectsConfirmation('Should this field be auto-increment?', 'yes')
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be the primary key?', 'yes')
            ->expectsConfirmation('Should this field be a foreign key?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'title')
            ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'yes')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be the primary key?', 'yes')
            ->expectsConfirmation('Should this field be a foreign key?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'body')
            ->expectsChoice('Choose property type', 'text', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be a foreign key?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'author_id')
            ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unsigned?', 'no')
            ->expectsConfirmation('Should this field be auto-increment?', 'no')
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be a foreign key?', 'yes')
            ->expectsQuestion('Which table should this foreign key point to?', 'authors')
            ->expectsQuestion('Which field should this foreign key point to?', 'id')
            ->expectsConfirmation('Do you want a relationship for this method?', 'yes')
            ->expectsQuestion('Enter the name for this relationship', 'author')
            ->expectsChoice('What should happen on row delete?', 'do nothing', ForeignKeyAction::all())
            ->expectsChoice('What should happen on row update?', 'do nothing', ForeignKeyAction::all())
            ->expectsConfirmation('Do you want to add a model property?', 'no')

            ->expectsChoice('You have specified multiple primary keys. Please select one', 'id', ['id', 'title'])

            ->expectsConfirmation('Do you want soft deletion for this model?', 'yes')
            ->expectsQuestion("No 'deleted_at' column found. Please enter name for timestamp column to be used for soft deletion.", 'deleted_at')

            ->expectsConfirmation('Do you want timestamps for this model?', 'yes')

            ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'yes')
            ->expectsConfirmation('Should web CRUD actions be authorized?', 'no')
            ->expectsConfirmation('Do you want web CRUD tests?', 'yes')

            ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $model = $specification->getModel();
        $this->assertEquals('Post', $model->getName());
        $this->assertEquals('App\Models\Post', $model->getFullyQualifiedName());
        $this->assertEquals('App\Models', $model->getFullNamespace());

        /** @var \Shomisha\Crudly\Specifications\ModelPropertySpecification[] $properties */
        $properties = $specification->getProperties();
        $this->assertInstanceOf(Collection::class, $properties);
        $this->assertCount(4, $properties);

        $id = $properties['id'];
        $this->assertEquals('id', $id->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $id->getType());
        $this->assertTrue($id->isUnsigned());
        $this->assertTrue($id->isAutoincrement());
        $this->assertFalse($id->isUnique());
        $this->assertFalse($id->isNullable());
        $this->assertTrue($id->isPrimaryKey());
        $this->assertFalse($id->isForeignKey());

        $title = $properties['title'];
        $this->assertEquals('title', $title->getName());
        $this->assertEquals(ModelPropertyType::STRING(), $title->getType());
        $this->assertTrue($title->isUnique());
        $this->assertFalse($title->isNullable());
        $this->assertTrue($title->isPrimaryKey());
        $this->assertFalse($title->isForeignKey());

        $body = $properties['body'];
        $this->assertEquals('body', $body->getName());
        $this->assertEquals(ModelPropertyType::TEXT(), $body->getType());
        $this->assertFalse($body->isUnique());
        $this->assertFalse($body->isNullable());
        $this->assertFalse($body->isPrimaryKey());
        $this->assertFalse($body->isForeignKey());

        $authorId = $properties['author_id'];
        $this->assertEquals('author_id', $authorId->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $authorId->getType());
        $this->assertFalse($authorId->isUnique());
        $this->assertFalse($authorId->isNullable());
        $this->assertFalse($authorId->isPrimaryKey());
        $this->assertTrue($authorId->isForeignKey());
        $this->assertEquals('authors', $authorId->getForeignKeySpecification()->getForeignKeyTable());
        $this->assertEquals('id', $authorId->getForeignKeySpecification()->getForeignKeyField());
        $this->assertEquals('author', $authorId->getForeignKeySpecification()->getRelationshipName());
        $this->assertEquals(ForeignKeyAction::DO_NOTHING(), $authorId->getForeignKeySpecification()->getForeignKeyOnDelete());
        $this->assertEquals(ForeignKeyAction::DO_NOTHING(), $authorId->getForeignKeySpecification()->getForeignKeyOnUpdate());

        $this->assertEquals('id', $specification->getPrimaryKey()->getName());

        $this->assertTrue($specification->hasSoftDeletion());
        $this->assertEquals('deleted_at', $specification->softDeletionColumnName());

        $this->assertTrue($specification->hasTimestamps());

        $this->assertTrue($specification->hasWeb());
        $this->assertFalse($specification->hasWebAuthorization());
        $this->assertTrue($specification->hasWebTests());

        $this->assertFalse($specification->hasApiTests());
        $this->assertFalse($specification->hasApiAuthorization());
        $this->assertFalse($specification->hasApiTests());
    }

    /** @test */
    public function wizard_will_ask_for_model_name()
    {
        $this->artisan('crudly:model')
            ->expectsQuestion("Enter the name of your model", "Post")

            ->expectsOutput('Define model properties:')
            ->expectsQuestion('Enter property name', 'id')
            ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unsigned?', 'yes')
            ->expectsConfirmation('Should this field be auto-increment?', 'yes')
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be the primary key?', 'yes')
            ->expectsConfirmation('Should this field be a foreign key?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'no')

            ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
            ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
            ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
            ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $model = $specification->getModel();
        $this->assertEquals('Post', $model->getName());
        $this->assertEquals('App\Models\Post', $model->getFullyQualifiedName());
    }

    /** @test */
    public function wizard_will_not_accept_invalid_model_name()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion("Enter the name of your model", "Po-st")
             ->expectsOutput('The name you entered is invalid.')
             ->expectsQuestion('Enter the name of your model', '_Post#')
             ->expectsOutput('The name you entered is invalid.')
             ->expectsQuestion('Enter the name of your model', 'Post!')
             ->expectsOutput('The name you entered is invalid.')
             ->expectsQuestion('Enter the name of your model', 'Author')


             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $model = $specification->getModel();
        $this->assertEquals('Author', $model->getName());
        $this->assertEquals('App\Models\Author', $model->getFullyQualifiedName());
    }

    /** @test */
    public function wizard_will_accept_model_name_with_namespaces()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion("Enter the name of your model", "Newsletter\Author\Blogger")

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $model = $specification->getModel();
        $this->assertEquals('Blogger', $model->getName());
        $this->assertEquals('Newsletter\Author', $model->getNamespace());
        $this->assertEquals('App\Models\Newsletter\Author\Blogger', $model->getFullyQualifiedName());
    }

    /** @test */
    public function wizard_will_require_overriding_confirmation_if_model_exists()
    {
        $this->crudly->withModelSupervisor(
            $supervisor = \Mockery::mock(\Shomisha\Crudly\Utilities\ModelSupervisor::class)
        );

        $supervisor->expects('modelNameIsValid')->with('Post')->andReturnTrue();
        $supervisor->expects('modelExists')->with('Post')->andReturnTrue()->once();
        $supervisor->expects('parseModelName')->andReturn(new ModelName('Post', 'App\Models', null));


        $this->artisan('crudly:model')
             ->expectsQuestion("Enter the name of your model", "Post")

             ->expectsConfirmation('This model already exists. Do you want to override it?', 'yes')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $model = $specification->getModel();
        $this->assertEquals('Post', $model->getName());
        $this->assertEquals('App\Models\Post', $model->getFullyQualifiedName());
    }

    /** @test */
    public function wizard_will_abort_if_overriding_confirmation_is_rejected()
    {
        $this->crudly->withModelSupervisor(
            $supervisor = \Mockery::mock(\Shomisha\Crudly\Utilities\ModelSupervisor::class)
        );

        $supervisor->expects('modelNameIsValid')->with('Post')->andReturnTrue();
        $supervisor->expects('modelExists')->with('Post')->andReturnTrue();


        $this->artisan('crudly:model')
             ->expectsQuestion("Enter the name of your model", "Post")

             ->expectsConfirmation('This model already exists. Do you want to override it?', 'no')

             ->expectsOutput('Cancelled.');


        $this->assertFalse($this->crudly->hasLastSpecification());
    }

    /** @test */
    public function wizard_will_ask_for_model_properties()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'no')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'body')
             ->expectsChoice('Choose property type', 'text', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'published_at')
            ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'yes')
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'author_id')
            ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unsigned?', 'yes')
            ->expectsConfirmation('Should this field be auto-increment?', 'no')
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be a foreign key?', 'yes')
            ->expectsQuestion('Which table should this foreign key point to?', 'authors')
            ->expectsQuestion('Which field should this foreign key point to?', 'id')
            ->expectsConfirmation('Do you want a relationship for this method?', 'yes')
            ->expectsQuestion('Enter the name for this relationship', 'author')
            ->expectsChoice('What should happen on row delete?', 'do nothing', ForeignKeyAction::all())
            ->expectsChoice('What should happen on row update?', 'do nothing', ForeignKeyAction::all())
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'category_id')
            ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unsigned?', 'yes')
            ->expectsConfirmation('Should this field be auto-increment?', 'no')
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be a foreign key?', 'yes')
            ->expectsQuestion('Which table should this foreign key point to?', 'categories')
            ->expectsQuestion('Which field should this foreign key point to?', 'id')
            ->expectsConfirmation('Do you want a relationship for this method?', 'no')
            ->expectsChoice('What should happen on row delete?', 'do nothing', ForeignKeyAction::all())
            ->expectsChoice('What should happen on row update?', 'do nothing', ForeignKeyAction::all())
            ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $properties = $specification->getProperties();
        $this->assertInstanceOf(Collection::class, $properties);

        $id = $properties['id'];
        $this->assertEquals('id', $id->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $id->getType());
        $this->assertTrue($id->isUnsigned());
        $this->assertFalse($id->isNullable());
        $this->assertFalse($id->isUnique());
        $this->assertTrue($id->isPrimaryKey());
        $this->assertFalse($id->isForeignKey());

        $title = $properties['title'];
        $this->assertEquals('title', $title->getName());
        $this->assertEquals(ModelPropertyType::STRING(), $title->getType());
        $this->assertFalse($title->isNullable());
        $this->assertTrue($title->isUnique());
        $this->assertFalse($title->isPrimaryKey());
        $this->assertFalse($title->isForeignKey());

        $body = $properties['body'];
        $this->assertEquals('body', $body->getName());
        $this->assertEquals(ModelPropertyType::TEXT(), $body->getType());
        $this->assertFalse($body->isNullable());
        $this->assertFalse($body->isUnique());
        $this->assertFalse($body->isPrimaryKey());
        $this->assertFalse($body->isForeignKey());

        $publishedAt = $properties['published_at'];
        $this->assertEquals('published_at', $publishedAt->getName());
        $this->assertEquals(ModelPropertyType::TIMESTAMP(), $publishedAt->getType());
        $this->assertTrue($publishedAt->isNullable());
        $this->assertFalse($publishedAt->isUnique());
        $this->assertFalse($publishedAt->isPrimaryKey());
        $this->assertFalse($publishedAt->isForeignKey());

        $authorId = $properties['author_id'];
        $this->assertEquals('author_id', $authorId->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $authorId->getType());
        $this->assertTrue($authorId->isUnsigned());
        $this->assertFalse($authorId->isNullable());
        $this->assertFalse($authorId->isUnique());
        $this->assertFalse($authorId->isPrimaryKey());
        $this->assertTrue($authorId->isForeignKey());

        $authorIdForeign = $authorId->getForeignKeySpecification();
        $this->assertEquals('id', $authorIdForeign->getForeignKeyField());
        $this->assertEquals('authors', $authorIdForeign->getForeignKeyTable());
        $this->assertTrue($authorIdForeign->hasRelationship());
        $this->assertEquals('author', $authorIdForeign->getRelationshipName());
        $this->assertEquals(ForeignKeyAction::DO_NOTHING(), $authorIdForeign->getForeignKeyOnUpdate());
        $this->assertEquals(ForeignKeyAction::DO_NOTHING(), $authorIdForeign->getForeignKeyOnDelete());

        $categoryId = $properties['category_id'];
        $this->assertEquals('category_id', $categoryId->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $categoryId->getType());
        $this->assertTrue($categoryId->isUnsigned());
        $this->assertFalse($categoryId->isNullable());
        $this->assertFalse($categoryId->isUnique());
        $this->assertFalse($categoryId->isPrimaryKey());
        $this->assertTrue($categoryId->isForeignKey());

        $categoryIdForeign = $categoryId->getForeignKeySpecification();
        $this->assertEquals('id', $categoryIdForeign->getForeignKeyField());
        $this->assertEquals('categories', $categoryIdForeign->getForeignKeyTable());
        $this->assertFalse($categoryIdForeign->hasRelationship());
        $this->assertNull($categoryIdForeign->getRelationshipName());
    }

    /** @test */
    public function wizard_will_ask_if_number_columns_should_be_unsigned()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'no')

            ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
            ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
            ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
            ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $id = $specification->getProperties()['id'];
        $this->assertTrue($id->isUnsigned());
    }

    /** @test */
    public function wizard_will_ask_if_number_columns_should_be_auto_increment()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $id = $specification->getProperties()['id'];
        $this->assertTrue($id->isAutoincrement());
    }

    /** @test */
    public function wizard_will_ask_if_auto_increment_columns_should_be_primary_keys()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $id = $specification->getProperties()['id'];
        $this->assertTrue($id->isPrimaryKey());
    }

    /** @test */
    public function wizard_will_ask_if_columns_should_be_nullable()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'title')
            ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'yes')
            ->expectsConfirmation('Should this field be nullable?', 'yes')
            ->expectsConfirmation('Should this field be a foreign key?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $id = $specification->getProperties()['title'];
        $this->assertTrue($id->isNullable());
    }

    /** @test */
    public function wizard_will_not_ask_if_nullable_columns_should_be_the_primary_key()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $id = $specification->getProperties()['id'];
        $this->assertFalse($id->isPrimaryKey());
    }

    /** @test */
    public function wizard_will_ask_if_fields_should_be_unique()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->getProperties()['title']->isUnique());
    }

    /** @test */
    public function wizard_will_ask_if_unique_strings_should_be_primary_keys()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->getProperties()['title']->isPrimaryKey());
    }

    /** @test */
    public function wizard_will_not_ask_if_unique_but_nullable_strings_should_be_primary_keys()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertFalse($specification->getProperties()['title']->isPrimaryKey());
    }

    /** @test */
    public function wizard_will_ask_if_field_should_be_foreign_key()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

            ->expectsOutput('Define model properties:')
            ->expectsQuestion('Enter property name', 'author_id')
            ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unsigned?', 'no')
            ->expectsConfirmation('Should this field be auto-increment?', 'no')
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Should this field be a foreign key?', 'yes')
            ->expectsQuestion('Which table should this foreign key point to?', 'authors')
            ->expectsQuestion('Which field should this foreign key point to?', 'id')
            ->expectsConfirmation('Do you want a relationship for this method?', 'yes')
            ->expectsQuestion('Enter the name for this relationship', 'author')
            ->expectsChoice('What should happen on row delete?', 'do nothing', ForeignKeyAction::all())
            ->expectsChoice('What should happen on row update?', 'do nothing', ForeignKeyAction::all())
            ->expectsConfirmation('Do you want to add a model property?', 'no')

            ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
            ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
            ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
            ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();

        $authorId = $specification->getProperties()['author_id'];
        $this->assertEquals('author_id', $authorId->getName());
        $this->assertTrue($authorId->isForeignKey());

        $authorIdForeign = $authorId->getForeignKeySpecification();
        $this->assertEquals('id', $authorIdForeign->getForeignKeyField());
        $this->assertEquals('authors', $authorIdForeign->getForeignKeyTable());
        $this->assertTrue($authorIdForeign->hasRelationship());
        $this->assertEquals('author', $authorIdForeign->getRelationshipName());
        $this->assertEquals(ForeignKeyAction::DO_NOTHING(), $authorIdForeign->getForeignKeyOnUpdate());
        $this->assertEquals(ForeignKeyAction::DO_NOTHING(), $authorIdForeign->getForeignKeyOnDelete());
    }

    /** @test */
    public function wizard_will_not_ask_for_relationship_name_and_type_if_foreign_key_is_not_relationship()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'author_id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'no')
             ->expectsConfirmation('Should this field be auto-increment?', 'no')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be a foreign key?', 'yes')
             ->expectsQuestion('Which table should this foreign key point to?', 'authors')
             ->expectsQuestion('Which field should this foreign key point to?', 'id')
             ->expectsConfirmation('Do you want a relationship for this method?', 'no')
             ->expectsChoice('What should happen on row delete?', 'do nothing', ForeignKeyAction::all())
             ->expectsChoice('What should happen on row update?', 'do nothing', ForeignKeyAction::all())
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $authorId = $specification->getProperties()['author_id'];
        $this->assertTrue($authorId->isForeignKey());

        $authorIdForeign = $authorId->getForeignKeySpecification();
        $this->assertFalse($authorIdForeign->hasRelationship());
        $this->assertNull($authorIdForeign->getRelationshipName());
    }

    /** @test */
    public function wizard_will_keep_asking_for_new_fields_until_rejected()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'no')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');
    }

    /** @test */
    public function wizard_will_ask_for_single_selection_if_multiple_primary_keys_were_defined()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'title')
             ->expectsChoice('Choose property type', 'string', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'yes')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

            ->expectsChoice('You have specified multiple primary keys. Please select one', 'title', [
                'id',
                'title',
            ])

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertEquals('title', $specification->getPrimaryKey()->getName());
    }

    /** @test */
    public function wizard_will_ask_if_model_should_have_soft_deletion()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'deleted_at')
             ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'yes')

             ->expectsConfirmation('Do you want timestamps for this model?', 'no')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->hasSoftDeletion());
        $this->assertNull($specification->softDeletionColumnName());
    }

    /** @test */
    public function wizard_will_ask_user_to_choose_timestamp_field_if_deleted_at_field_is_not_present()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
            ->expectsQuestion('Enter property name', 'created_at')
            ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'published_at')
            ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'yes')

            ->expectsQuestion('Enter property name', 'archived_at')
            ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
            ->expectsConfirmation('Should this field be unique?', 'no')
            ->expectsConfirmation('Should this field be nullable?', 'no')
            ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'yes')
             ->expectsChoice("No 'deleted_at' column found. Please choose column for soft deletion", 'archived_at', [
                 'created_at',
                 'published_at',
                 'archived_at',
                 'Create new column'
             ])

             ->expectsConfirmation('Do you want timestamps for this model?', 'no')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->hasSoftDeletion());
        $this->assertEquals('archived_at', $specification->softDeletionColumnName());
    }

    /** @test */
    public function user_can_create_new_field_when_prompted_to_choose_timestamp_field()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'created_at')
             ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'published_at')
             ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'yes')

             ->expectsQuestion('Enter property name', 'archived_at')
             ->expectsChoice('Choose property type', 'timestamp', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'yes')
             ->expectsChoice("No 'deleted_at' column found. Please choose column for soft deletion", 'Create new column', [
                 'created_at',
                 'published_at',
                 'archived_at',
                 'Create new column'
             ])
             ->expectsQuestion('Enter column name', 'deleted_at')

             ->expectsConfirmation('Do you want timestamps for this model?', 'no')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->hasSoftDeletion());
        $this->assertEquals('deleted_at', $specification->softDeletionColumnName());
    }

    /** @test */
    public function wizard_will_ask_user_to_enter_soft_deletion_field_name_if_no_timestamps_are_present()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'yes')
             ->expectsQuestion("No 'deleted_at' column found. Please enter name for timestamp column to be used for soft deletion.", 'goodbye')

             ->expectsConfirmation('Do you want timestamps for this model?', 'yes')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->hasSoftDeletion());
        $this->assertEquals('goodbye', $specification->softDeletionColumnName());
    }

    /** @test */
    public function wizard_will_ask_if_model_should_have_timestamps()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')

             ->expectsConfirmation('Do you want timestamps for this model?', 'no')

             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')
             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertFalse($specification->hasTimestamps());
    }

    /** @test */
    public function wizard_will_ask_if_model_should_have_web_crud()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'no')

             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'yes')
             ->expectsConfirmation('Should web CRUD actions be authorized?', 'no')
             ->expectsConfirmation('Do you want web CRUD tests?', 'yes')

             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->hasWeb());
        $this->assertFalse($specification->hasWebAuthorization());
        $this->assertTrue($specification->hasWebTests());
    }

    /** @test */
    public function wizard_will_not_ask_about_web_authorization_and_tests_if_web_crud_is_rejected()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'no')

             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')

             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertFalse($specification->hasWeb());
        $this->assertFalse($specification->hasWebAuthorization());
        $this->assertFalse($specification->hasWebTests());
    }

    /** @test */
    public function wizard_will_ask_if_model_should_have_api_crud()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'no')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')

             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'yes')
             ->expectsConfirmation('Should API CRUD endpoints be authorized?', 'yes')
             ->expectsConfirmation('Do you want API CRUD tests?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertTrue($specification->hasApi());
        $this->assertTrue($specification->hasApiAuthorization());
        $this->assertFalse($specification->hasApiTests());
    }

    /** @test */
    public function wizard_will_not_ask_about_api_authorization_and_tests_if_api_crud_is_rejected()
    {
        $this->artisan('crudly:model')
             ->expectsQuestion('Enter the name of your model', 'Post')

             ->expectsOutput('Define model properties:')
             ->expectsQuestion('Enter property name', 'id')
             ->expectsChoice('Choose property type', 'big integer', ModelPropertyType::all())
             ->expectsConfirmation('Should this field be unsigned?', 'yes')
             ->expectsConfirmation('Should this field be auto-increment?', 'yes')
             ->expectsConfirmation('Should this field be unique?', 'no')
             ->expectsConfirmation('Should this field be nullable?', 'no')
             ->expectsConfirmation('Should this field be the primary key?', 'yes')
             ->expectsConfirmation('Should this field be a foreign key?', 'no')
             ->expectsConfirmation('Do you want to add a model property?', 'no')

             ->expectsConfirmation('Do you want soft deletion for this model?', 'no')
             ->expectsConfirmation('Do you want timestamps for this model?', 'no')
             ->expectsConfirmation('Should this model have web pages for CRUD actions?', 'no')

             ->expectsConfirmation('Should this model have API endpoints for CRUD actions?', 'no');


        $specification = $this->crudly->getLastSpecification();


        $this->assertFalse($specification->hasApi());
        $this->assertFalse($specification->hasApiAuthorization());
        $this->assertFalse($specification->hasApiTests());
    }
}
