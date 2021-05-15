<?php

namespace Shomisha\Crudly\Test\Unit;

use Shomisha\Crudly\Crudly;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Enums\ForeignKeyAction;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\DeveloperManager;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Specifications\ForeignKeySpecification;
use Shomisha\Crudly\Specifications\ModelPropertySpecification;
use Shomisha\Crudly\Test\Mocks\ModelSupervisorMock;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;
use Shomisha\Crudly\Utilities\FileSaver\TestFileSaver;
use Shomisha\Crudly\Utilities\ModelSupervisor;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class CrudlyTest extends TestCase
{
    /** @test */
    public function crudly_can_parse_model_name()
    {
        $modelSupervisor = \Mockery::mock(ModelSupervisorMock::class);
        $parseExpectation = $modelSupervisor->shouldReceive('parseModelName')->with('Result')->andReturn(
            new ModelName('Result', 'App\Models', null)
        );


        $crudly = new Crudly(
            $modelSupervisor,
            new DeveloperManager($this->getDeveloperConfig(), $this->app),
            new TestFileSaver()
        );
        $crudly->parseModelName('Result');


        $parseExpectation->verify();
    }

    /** @test */
    public function crudly_can_check_if_model_name_is_valid()
    {
        $modelSupervisor = \Mockery::mock(ModelSupervisorMock::class);
        $isValidExpectation = $modelSupervisor->shouldReceive('modelNameIsValid')
                                              ->with('Test#Random#Model')
                                              ->andReturnFalse();


        $crudly = new Crudly(
            $modelSupervisor,
            new DeveloperManager($this->getDeveloperConfig(), $this->app),
            new TestFileSaver()
        );
        $modelIsValid = $crudly->modelNameIsValid('Test#Random#Model');


        $isValidExpectation->verify();
        $this->assertFalse($modelIsValid);
    }

    /** @test */
    public function crudly_can_check_if_model_exists()
    {
        $modelSupervisor = \Mockery::mock(ModelSupervisorMock::class);
        $modelExistsExpectation = $modelSupervisor->shouldReceive('modelExists')
                                              ->with('Weapon')
                                              ->andReturnFalse();


        $crudly = new Crudly(
            $modelSupervisor,
            new DeveloperManager($this->getDeveloperConfig(), $this->app),
            new TestFileSaver()
        );
        $modelExists = $crudly->modelExists('Weapon');


        $modelExistsExpectation->verify();
        $this->assertFalse($modelExists);
    }

    /** @test */
    public function crudly_can_prepare_specification()
    {
        $input = [
            'model' => 'Author',
            'properties' => [
                [
                    'name' => 'id',
                    'type' => 'big integer',
                    'is_autoincrement' => true,
                    'is_unsigned' => true,
                    'is_unique' => false,
                    'is_nullable' => false,
                    'is_primary' => true,
                    'is_foreign_key' => false,
                ],
                [
                    'name' => 'name',
                    'type' => 'string',
                    'is_autoincrement' => false,
                    'is_unsigned' => false,
                    'is_unique' => false,
                    'is_nullable' => false,
                    'is_primary' => false,
                    'is_foreign_key' => false,
                ],
                [
                    'name' => 'email',
                    'type' => 'email',
                    'is_autoincrement' => false,
                    'is_unsigned' => false,
                    'is_unique' => true,
                    'is_nullable' => false,
                    'is_primary' => false,
                    'is_foreign_key' => false,
                ],
                [
                    'name' => 'publisher_id',
                    'type' => 'big integer',
                    'is_autoincrement' => false,
                    'is_unsigned' => true,
                    'is_unique' => false,
                    'is_nullable' => true,
                    'is_primary' => false,
                    'is_foreign_key' => true,
                    'foreign_key_target' => [
                        'table' => 'publishers',
                        'field' => 'id',
                        'has_relationship' => true,
                        'relationship' => [
                            'name' => 'publisher'
                        ],
                        'on_delete' => 'cascade',
                        'on_update' => 'no action'
                    ],
                ],
            ],
            'has_soft_deletion' => true,
            'has_timestamps' => true,
            'has_web_authorization' => false,
            'has_web_tests' => true,
            'has_api_authorization' => true,
            'has_api_tests' => false,
        ];

        $modelSupervisor = \Mockery::mock(ModelSupervisor::class);
        $modelSupervisor->shouldReceive('parseModelName')->with('Author')->andReturn(
            new ModelName('Author', 'App', null)
        );


        $crudly = new Crudly(
          $modelSupervisor,
            new DeveloperManager($this->getDeveloperConfig(), $this->app),
            new TestFileSaver()
        );
        $specification = $crudly->prepareSpecification($input);


        $this->assertInstanceOf(CrudlySpecification::class, $specification);

        $this->assertInstanceOf(ModelName::class, $specification->getModel());
        $this->assertEquals('Author', $specification->getModel()->getName());
        $this->assertNull($specification->getModel()->getNamespace());
        $this->assertEquals('App', $specification->getModel()->getFullNamespace());

        $this->assertTrue($specification->hasSoftDeletion());
        $this->assertTrue($specification->hasTimestamps());
        $this->assertFalse($specification->hasWebAuthorization());
        $this->assertTrue($specification->hasWebTests());
        $this->assertTrue($specification->hasApiAuthorization());
        $this->assertFalse($specification->hasApiTests());

        $properties = $specification->getProperties();
        $this->assertCount(4, $properties);

        $firstProperty = $properties['id'];
        $this->assertInstanceOf(ModelPropertySpecification::class, $firstProperty);
        $this->assertEquals($specification->getPrimaryKey(), $firstProperty);
        $this->assertEquals('id', $firstProperty->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $firstProperty->getType());
        $this->assertTrue($firstProperty->isAutoincrement());
        $this->assertTrue($firstProperty->isUnsigned());
        $this->assertFalse($firstProperty->isUnique());
        $this->assertFalse($firstProperty->isNullable());
        $this->assertTrue($firstProperty->isPrimaryKey());
        $this->assertFalse($firstProperty->isForeignKey());
        $this->assertNull($firstProperty->getForeignKeySpecification());

        $secondProperty = $properties['name'];
        $this->assertInstanceOf(ModelPropertySpecification::class, $secondProperty);
        $this->assertEquals('name', $secondProperty->getName());
        $this->assertEquals(ModelPropertyType::STRING(), $secondProperty->getType());
        $this->assertFalse($secondProperty->isAutoincrement());
        $this->assertFalse($secondProperty->isUnsigned());
        $this->assertFalse($secondProperty->isUnique());
        $this->assertFalse($secondProperty->isNullable());
        $this->assertFalse($secondProperty->isPrimaryKey());
        $this->assertFalse($secondProperty->isForeignKey());
        $this->assertNull($secondProperty->getForeignKeySpecification());

        $thirdProperty = $properties['email'];
        $this->assertInstanceOf(ModelPropertySpecification::class, $thirdProperty);
        $this->assertEquals('email', $thirdProperty->getName());
        $this->assertEquals(ModelPropertyType::EMAIL(), $thirdProperty->getType());
        $this->assertFalse($thirdProperty->isAutoincrement());
        $this->assertFalse($thirdProperty->isUnsigned());
        $this->assertTrue($thirdProperty->isUnique());
        $this->assertFalse($thirdProperty->isNullable());
        $this->assertFalse($thirdProperty->isPrimaryKey());
        $this->assertFalse($thirdProperty->isForeignKey());
        $this->assertNull($thirdProperty->getForeignKeySpecification());

        $fourthProperty = $properties['publisher_id'];
        $this->assertInstanceOf(ModelPropertySpecification::class, $fourthProperty);
        $this->assertEquals('publisher_id', $fourthProperty->getName());
        $this->assertEquals(ModelPropertyType::BIG_INT(), $fourthProperty->getType());
        $this->assertFalse($fourthProperty->isAutoincrement());
        $this->assertTrue($fourthProperty->isUnsigned());
        $this->assertFalse($fourthProperty->isUnique());
        $this->assertTrue($fourthProperty->isNullable());
        $this->assertFalse($fourthProperty->isPrimaryKey());
        $this->assertTrue($fourthProperty->isForeignKey());

        $foreignKeySpecification = $fourthProperty->getForeignKeySpecification();
        $this->assertInstanceOf(ForeignKeySpecification::class, $foreignKeySpecification);
        $this->assertEquals('publishers', $foreignKeySpecification->getForeignKeyTable());
        $this->assertEquals('id', $foreignKeySpecification->getForeignKeyField());
        $this->assertEquals('publisher', $foreignKeySpecification->getRelationshipName());
        $this->assertEquals(ForeignKeyAction::CASCADE(), $foreignKeySpecification->getForeignKeyOnDelete());
        $this->assertEquals(ForeignKeyAction::NO_ACTION(), $foreignKeySpecification->getForeignKeyOnUpdate());
    }

    /** @test */
    public function crudly_can_develop_a_crudly_set()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Game')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->webCrud(true)
            ->webTests(true)
            ->webAuthorization(true)
            ->apiCrud(true)
            ->apiTests(true);


        $crudly = new Crudly(
            new ModelSupervisor(
                $this->app->get('files'),
                'app',
                'App',
            ),
            new DeveloperManager($this->getDeveloperConfig(), $this->app),
            new TestFileSaver()
        );
        $crudlySet = $crudly->develop($specificationBuilder->build());


        $this->assertInstanceOf(CrudlySet::class, $crudlySet);

        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getMigration());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getModel());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getFactory());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getWebCrudController());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getWebCrudFormRequest());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getWebTests());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getPolicy());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getApiCrudController());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getApiCrudFormRequest());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getApiCrudApiResource());
        $this->assertInstanceOf(ClassTemplate::class, $crudlySet->getApiTests());
    }
}
