<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api;

use Faker\Factory;
use Faker\Generator;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\ApiTestsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\ApiTestsDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ApiTestsDeveloperTest extends DeveloperTestCase
{
    private function fakeFaker(array $expectations = []): Factory
    {
        $factory = \Mockery::mock(Factory::class);
        $generator = \Mockery::mock(Generator::class);

        foreach ($expectations as $type => $value) {
            $generator->{$type} = $value;
        }

        $factory->shouldReceive('create')->andReturn($generator);

        $this->app->instance(Factory::class, $factory);
        return $factory;
    }

    /** @test */
    public function developer_can_develop_api_tests()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('publisher_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'publishers')
                ->isRelationship('publisher')
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'countries')
                ->isRelationship('country')
            ->apiAuthorization(true)
            ->softDeletes(true)
            ->softDeletionColumn('stopped_writing_at');

        $this->modelSupervisor->expectedExistingModels(['Publisher']);

        $this->fakeFaker([
            'name' => 'J. K. Rowling',
            'email' => 'jk@rowling.com',
        ]);


        $manager = new ApiTestsDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ApiTestsDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $testClass = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertInstanceOf(ClassTemplate::class, $testClass);
        $this->assertEquals($testClass, $developedSet->getApiTests());

        $printedClass = $testClass->print();

        $this->assertStringContainsString("namespace Tests\Feature\Web;", $printedClass);
        $this->assertStringContainsString("use App\Models\Author;", $printedClass);
        $this->assertStringContainsString("use App\Models\Publisher;", $printedClass);
        $this->assertStringContainsString("use App\Models\User;", $printedClass);
        $this->assertStringContainsString("use Shomisha\Crudly\Exceptions\IncompleteTestException;", $printedClass);
        $this->assertStringContainsString("use Tests\TestCase;", $printedClass);

        $this->assertStringContainsString(implode("\n", [
            "class AuthorTest extends TestCase",
            "{",
            "    public function createAndAuthenticateUser() : User",
            "    {",
            "        \$user = User::factory()->create();",
            "        \$this->be(\$user);\n",

            "        return \$user;",
            "    }\n",

            "    private function getAuthorData(array \$override = []) : array",
            "    {",
            "        if (!array_key_exists('manager_id', \$override)) {",
            "            throw IncompleteTestException::provideMissingForeignKey('manager_id');",
            "        }",
            "        if (!array_key_exists('publisher_uuid', \$override)) {",
            "            \$override['publisher_uuid'] = Publisher::factory()->create()->uuid;",
            "        }",
            "        if (!array_key_exists('country_id', \$override)) {",
            "            throw IncompleteTestException::provideMissingForeignKey('country_id');",
            "        }\n",

            "        return array_merge(['name' => 'J. K. Rowling', 'email' => 'jk@rowling.com'], \$override);",
            "    }\n",

            "    private function authorizeUser(User \$user) : void",
            "    {",
            "        throw IncompleteTestException::provideUserAuthorization();",
            "    }\n",

            "    private function deauthorizeUser(User \$user) : void",
            "    {",
            "        throw IncompleteTestException::provideUserDeauthorization();",
            "    }\n",

            "    private function getIndexRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('index');",
            "    }\n",

            "    private function getShowRoute(Author \$author) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('show');",
            "    }\n",

            "    private function getStoreRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('store');",
            "    }\n",

            "    private function getUpdateRoute(Author \$author) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('update');",
            "    }\n",

            "    private function getDestroyRoute(Author \$author) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('destroy');",
            "    }\n",

            "    private function getForceDeleteRoute(Author \$author) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('force-delete');",
            "    }\n",

            "    private function getRestoreRoute(Author \$author) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('restore');",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_a_list_of_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$authors = Author::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorIds = collect(\$response->json('data'))->pluck('uuid');",
            "        \$this->assertCount(\$authors->count(), \$responseAuthorIds);",
            "        foreach (\$authors as \$author) {",
            "            \$this->assertContains(\$author->uuid, \$responseAuthorIds);",
            "        }",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_get_the_authors_list()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorId = \$response->json('data.uuid');",
            "        \$this->assertEquals(\$author->uuid, \$responseAuthorId);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(201);",
            "        \$this->assertDatabaseHas('authors', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",

            "    public function invalidAuthorDataProvider()",
            "    {",
            "        return ['Name is not a string' => ['name', false], 'Name is missing' => ['name', null], 'Email is not an email' => ['email', 'not an email'], 'Email is missing' => ['email', null], 'Manager id is not an integer' => ['manager_id', 'not an integer'], 'Manager id is missing' => ['manager_id', null], 'Publisher uuid is not a string' => ['publisher_uuid', false], 'Publisher uuid is missing' => ['publisher_uuid', null], 'Country id is not an integer' => ['country_id', 'not an integer'], 'Country id is missing' => ['country_id', null]];",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_create_new_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_create_new_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertEquals('New Name', \$author->name);",
            "        \$this->assertEquals('new@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_update_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNotNull(\$author->stopped_writing_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->stopped_writing_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_force_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_force_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->stopped_writing_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_restore_soft_deleted_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['stopped_writing_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->stopped_writing_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_restore_soft_deleted_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create(['stopped_writing_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertNotNull(\$author->stopped_writing_at);",
            "    }",
            "}",
        ]), $printedClass);
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('publisher_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'publishers')
                ->isRelationship('publisher')
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'countries')
                ->isRelationship('country')
            ->apiAuthorization(false)
            ->webAuthorization(true)
            ->softDeletes(true)
            ->softDeletionColumn('stopped_writing_at');

        $this->modelSupervisor->expectedExistingModels(['Publisher']);

        $this->fakeFaker([
            'name' => 'J. K. Rowling',
            'email' => 'jk@rowling.com',
        ]);


        $manager = new ApiTestsDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ApiTestsDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $testClass = $developer->develop($specificationBuilder->build(), $developedSet);

        $printedClass = $testClass->print();
        $this->assertStringNotContainsString('private function authorizeUser(User $user)', $printedClass);
        $this->assertStringNotContainsString('private function deauthorizeUser(User $user)', $printedClass);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_a_list_of_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$authors = Author::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorIds = collect(\$response->json('data'))->pluck('uuid');",
            "        \$this->assertCount(\$authors->count(), \$responseAuthorIds);",
            "        foreach (\$authors as \$author) {",
            "            \$this->assertContains(\$author->uuid, \$responseAuthorIds);",
            "        }",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorId = \$response->json('data.uuid');",
            "        \$this->assertEquals(\$author->uuid, \$responseAuthorId);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(201);",
            "        \$this->assertDatabaseHas('authors', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",

            "    public function invalidAuthorDataProvider()",
            "    {",
            "        return ['Name is not a string' => ['name', false], 'Name is missing' => ['name', null], 'Email is not an email' => ['email', 'not an email'], 'Email is missing' => ['email', null], 'Manager id is not an integer' => ['manager_id', 'not an integer'], 'Manager id is missing' => ['manager_id', null], 'Publisher uuid is not a string' => ['publisher_uuid', false], 'Publisher uuid is missing' => ['publisher_uuid', null], 'Country id is not an integer' => ['country_id', 'not an integer'], 'Country id is missing' => ['country_id', null]];",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_create_new_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertEquals('New Name', \$author->name);",
            "        \$this->assertEquals('new@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_update_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNotNull(\$author->stopped_writing_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_force_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_restore_soft_deleted_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create(['stopped_writing_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->stopped_writing_at);",
            "    }",
        ]), $printedClass);
    }

    /** @test */
    public function developer_will_omit_soft_deletion_tests_if_soft_deletion_is_not_required()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('publisher_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'publishers')
                ->isRelationship('publisher')
            ->property('country_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'countries')
                ->isRelationship('country')
            ->apiAuthorization(true)
            ->softDeletes(false);

        $this->modelSupervisor->expectedExistingModels(['Publisher']);

        $this->fakeFaker([
            'name' => 'J. K. Rowling',
            'email' => 'jk@rowling.com',
        ]);


        $manager = new ApiTestsDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new ApiTestsDeveloper($manager, $this->modelSupervisor);
        $developedSet = new CrudlySet();
        $testClass = $developer->develop($specificationBuilder->build(), $developedSet);


        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_a_list_of_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$authors = Author::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorIds = collect(\$response->json('data'))->pluck('uuid');",
            "        \$this->assertCount(\$authors->count(), \$responseAuthorIds);",
            "        foreach (\$authors as \$author) {",
            "            \$this->assertContains(\$author->uuid, \$responseAuthorIds);",
            "        }",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_get_the_authors_list()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorId = \$response->json('data.uuid');",
            "        \$this->assertEquals(\$author->uuid, \$responseAuthorId);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(201);",
            "        \$this->assertDatabaseHas('authors', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",

            "    public function invalidAuthorDataProvider()",
            "    {",
            "        return ['Name is not a string' => ['name', false], 'Name is missing' => ['name', null], 'Email is not an email' => ['email', 'not an email'], 'Email is missing' => ['email', null], 'Manager id is not an integer' => ['manager_id', 'not an integer'], 'Manager id is missing' => ['manager_id', null], 'Publisher uuid is not a string' => ['publisher_uuid', false], 'Publisher uuid is missing' => ['publisher_uuid', null], 'Country id is not an integer' => ['country_id', 'not an integer'], 'Country id is missing' => ['country_id', null]];",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_create_new_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_create_new_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertEquals('New Name', \$author->name);",
            "        \$this->assertEquals('new@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_update_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseHas('authors', ['uuid' => \$author->uuid]);",
            "    }",
            "}",
        ]), $testClass->print());
    }

    /** @test */
    public function developer_will_delegate_helper_methods_and_test_methods_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->apiAuthorization(true)
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at');

        $this->manager->arraysOfDevelopers([
            'getRouteMethodDevelopers',
            'getHelperMethodDevelopers',
            'getAuthorizationHelperMethodDevelopers',
        ]);

        $expectedDevelopers = [
            'getIndexTestDeveloper',
            'getUnauthorizedIndexTestDeveloper',
            'getShowDeveloper',
            'getUnauthorizedShowDeveloper',
            'getStoreDeveloper',
            'getInvalidDataProviderDeveloper',
            'getInvalidStoreDeveloper',
            'getUnauthorizedStoreDeveloper',
            'getUpdateDeveloper',
            'getInvalidUpdateDeveloper',
            'getUnauthorizedUpdateDeveloper',
            'getDestroyDeveloper',
            'getUnauthorizedDestroyDeveloper',
            'getForceDeleteDeveloper',
            'getUnauthorizedForceDeleteDeveloper',
            'getRestoreDeveloper',
            'getUnauthorizedRestoreDeveloper',
        ];

        $this->manager->methodDevelopers($expectedDevelopers);


        $developer = new ApiTestsDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertArrayOfDevelopersRequested('getRouteMethodDevelopers');
        $this->manager->assertArrayOfDevelopersRequested('getHelperMethodDevelopers');
        $this->manager->assertArrayOfDevelopersRequested('getAuthorizationHelperMethodDevelopers');

        foreach ($expectedDevelopers as $expectedDeveloper) {
            $this->manager->assertMethodDeveloperRequested($expectedDeveloper);
        }
    }
}
