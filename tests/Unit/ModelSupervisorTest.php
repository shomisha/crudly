<?php

namespace Shomisha\Crudly\Test\Unit;

use Illuminate\Filesystem\Filesystem;
use Shomisha\Crudly\Data\ModelName;
use Shomisha\Crudly\Test\TestCase;
use Shomisha\Crudly\Utilities\ModelSupervisor;

class ModelSupervisorTest extends TestCase
{
    public function modelNameDataProvider()
    {
        return [
            [
                "User",
                "User",
                "App\Models\User",
                "App",
            ],
            [
                "Posts\Author",
                "Author",
                "SomeApplication\Models\Posts\Author",
                "SomeApplication",
            ],
            [
                "Blog\Posts\Comment",
                "Comment",
                "TestApp\Models\Blog\Posts\Comment",
                "TestApp",
            ],
        ];
    }

    /**
     * @test
     * @dataProvider modelNameDataProvider
     */
    public function model_supervisor_can_parse_model_name(string $rawModelName, string $parsedModelName, string $expectedModelFullName, string $rootNamespace)
    {
        $filesystem = \Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('isDirectory')->with("/webapps/current/app/Models")->andReturnTrue();


        $supervisor = new ModelSupervisor(
            $filesystem,
            '/webapps/current/app',
            $rootNamespace
        );
        $modelName = $supervisor->parseModelName($rawModelName);


        $this->assertInstanceOf(ModelName::class, $modelName);
        $this->assertEquals($parsedModelName, $modelName->getName());
        $this->assertEquals($expectedModelFullName, $modelName->getFullyQualifiedName());
    }

    public function invalidModelNameDataProvider()
    {
        return [
            ['I am invalid'],
            ['Invalid-class-name'],
            ['I#contain!invalid@characters'],
            ['!)%(!&%!_)(%!"'],
        ];
    }

    /**
     * @test
     * @dataProvider invalidModelNameDataProvider
     */
    public function model_supervisor_will_not_parse_invalid_model_name(string $invalidModelName)
    {
        $supervisor = new ModelSupervisor(
            $this->app->get('files'),
            '/webapps/current',
            'App'
        );


        $this->expectException(\InvalidArgumentException::class);
        $supervisor->parseModelName($invalidModelName);
    }

    public function tablesToModelsDataProvider()
    {
        return [
            ['users', 'User'],
            ['posts', 'Post'],
            ['cars', 'Car'],
            ['crises', 'Crisis'],
            ['criteria', 'Criterion']
        ];
    }

    /**
     * @test
     * @dataProvider tablesToModelsDataProvider
     */
    public function model_supervisor_can_parse_model_name_from_table_name(string $tableName, string $expectedModelName)
    {
        $supervisor = new ModelSupervisor(
            $this->app->get('files'),
            '/webapps/current',
            'App'
        );


        $modelName = $supervisor->parseModelNameFromTable($tableName);


        $this->assertInstanceOf(ModelName::class, $modelName);
        $this->assertEquals($expectedModelName, $modelName->getName());
    }

    public function validModelNameDataProvider()
    {
        return [
            ['Author', true],
            ['Post', true],
            ['Criterion', true],
            ['Invalid model name', false],
            ['Invalid#characters', false],
            ['!%!)^(&!#^', false],
        ];
    }

    /**
     * @test
     * @dataProvider validModelNameDataProvider
     */
    public function model_supervisor_can_check_if_model_name_is_valid(string $modelName, bool $expectedIsValid)
    {
        $supervisor = new ModelSupervisor(
            $this->app->get('files'),
            '/webapps/current',
            'App'
        );


        $actualIsValid = $supervisor->modelNameIsValid($modelName);


        $this->assertEquals($expectedIsValid, $actualIsValid);
    }

    public function modelExistsDataProvider()
    {
        return [
            "Exists" => ['TestModel', true,],
            "Does not exist" => ['NonExistingModel', false],
        ];
    }

    /**
     * @test
     * @dataProvider modelExistsDataProvider
     */
    public function model_supervisor_can_check_if_model_exists(string $model, bool $expectedExists)
    {
        $supervisor = new ModelSupervisor(
            $this->app->get('files'),
            '/webapps/current/tests/Fixtures',
            'Shomisha\Crudly\Test\Unit\Fixtures',
        );


        $actualExists = $supervisor->modelExists($model);


        $this->assertEquals($expectedExists, $actualExists);
    }

    /**
     * @test
     * @testWith [true]
     *           [false]
     */
    public function model_supervisor_can_check_if_models_directory_should_be_used(bool $expectedExists)
    {
        $filesystem = \Mockery::mock(Filesystem::class);
        $filesystem->shouldReceive('isDirectory')->with('/webapps/current/app/Models')->andReturn($expectedExists);


        $supervisor = new ModelSupervisor(
            $filesystem,
            '/webapps/current/app',
            'Shomisha\Crudly\Test\Unit\Fixtures',
        );
        $actualExists = $supervisor->shouldUseModelsDirectory();


        $this->assertEquals($expectedExists, $actualExists);
    }
}
