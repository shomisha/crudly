<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web;

use Faker\Factory;
use Faker\Generator;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\WebTestsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\WebTestsDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class WebTestsDeveloperTest extends DeveloperTestCase
{
    private function fakeFaker(array $expectations = []): Generator
    {
        $factory = \Mockery::mock(Factory::class);
        $generator = \Mockery::mock(Generator::class);

        foreach ($expectations as $type => $value) {
            $generator->{$type} = $value;
        }

        $factory->shouldReceive('create')->andReturn($generator);

        $this->app->instance(Factory::class, $factory);
        return $generator;
    }

    /** @test */
    public function developer_can_develop_web_tests()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('career_goals', ModelPropertyType::INT())
                ->unsigned()
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('club_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'clubs')
                ->isRelationship('club')
            ->softDeletes(true)
            ->softDeletionColumn('retired_at')
            ->webAuthorization(true);

        $this->modelSupervisor->expectedExistingModels(['Club']);

        $faker = $this->fakeFaker(['name' => 'Zlatan Ibrahimovic', 'email' => 'lion@golden.com']);
        $faker->shouldReceive('randomNumber')->andReturn(130);


        $manager = new WebTestsDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new WebTestsDeveloper($manager, $this->modelSupervisor);
        $testClass = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassTemplate::class, $testClass);

        $printedClass = $testClass->print();

        $this->assertStringContainsString("namespace Tests\Feature\Web;", $printedClass);

        $this->assertStringContainsString("use App\Models\Club;", $printedClass);
        $this->assertStringContainsString("use App\Models\Player;", $printedClass);
        $this->assertStringContainsString("use App\Models\User;", $printedClass);
        $this->assertStringContainsString("use Shomisha\Crudly\Exceptions\IncompleteTestException;", $printedClass);
        $this->assertStringContainsString("use Tests\TestCase;", $printedClass);

        $this->assertStringContainsString(implode("\n", [
            "class PlayerTest extends TestCase",
            "{",
            "    public function createAndAuthenticateUser() : User",
            "    {",
            "        \$user = User::factory()->create();",
            "        \$this->be(\$user);\n",

            "        return \$user;",
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

            "    private function getShowRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('show');",
            "    }\n",

            "    private function getCreateRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('create');",
            "    }\n",

            "    private function getStoreRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('store');",
            "    }\n",

            "    private function getEditRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('edit');",
            "    }\n",

            "    private function getUpdateRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('update');",
            "    }\n",

            "    private function getDestroyRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('destroy');",
            "    }\n",

            "    private function getForceDeleteRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('force-delete');",
            "    }\n",

            "    private function getRestoreRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('restore');",
            "    }\n",

            "    private function getPlayerData(array \$override = []) : array",
            "    {",
            "        if (!array_key_exists('manager_id', \$override)) {",
            "            throw IncompleteTestException::provideMissingForeignKey('manager_id');",
            "        }",
            "        if (!array_key_exists('club_uuid', \$override)) {",
            "            \$override['club_uuid'] = Club::factory()->create()->uuid;",
            "        }\n",

            "        return array_merge(['name' => 'Zlatan Ibrahimovic', 'email' => 'lion@golden.com', 'career_goals' => 130], \$override);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function users_can_access_the_players_index_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$players = Player::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.index');",
            "        \$responsePlayerIds = collect(\$response->viewData('players'))->pluck('uuid');",
            "        \$this->assertCount(\$players->count(), \$responsePlayerIds);",
            "        foreach (\$players as \$player) {",
            "            \$this->assertContains(\$player->uuid, \$responsePlayerIds);",
            "        }",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function index_page_will_not_contain_soft_deleted_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$players = Player::factory()->count(5)->create();",
            "        \$player = Player::factory()->create(['retired_at' => now()]);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.index');",
            "        \$responsePlayerIds = collect(\$response->viewData('players'))->pluck('uuid');",
            "        \$this->assertNotContains(\$player->uuid, \$responsePlayerIds);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_players_index_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_single_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$player));",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.show');",
            "        \$responsePlayer = \$response->viewData('player');",
            "        \$this->assertTrue(\$player->is(\$responsePlayer));",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_player_single_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$player));",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.create');",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_visit_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_new_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$this->assertDatabaseHas('players', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",

            "    public function invalidPlayerDataProvider()",
            "    {",
            "        return ['Name is not a string' => ['name', false], 'Name is missing' => ['name', null], 'Email is not an email' => ['email', 'not an email'], 'Email is missing' => ['email', null], 'Career goals is not an integer' => ['career_goals', 'not an integer'], 'Career goals is missing' => ['career_goals', null], 'Manager id is not an integer' => ['manager_id', 'not an integer'], 'Manager id is missing' => ['manager_id', null], 'Club uuid is not a string' => ['club_uuid', false], 'Club uuid is missing' => ['club_uuid', null]];",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_create_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_users_cannot_crete_new_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$data = \$this->getPlayerData();",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_edit_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getEditRoute(\$player));",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.edit');",
            "        \$responsePlayer = \$response->viewData('player');",
            "        \$this->assertTrue(\$player->is(\$responsePlayer));",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_edit_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getEditRoute(\$player));",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertEquals('New Name', \$player->name);",
            "        \$this->assertEquals('new@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_update_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$player->refresh();",
            "        \$this->assertEquals('Old Name', \$player->name);",
            "        \$this->assertEquals('old@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_update_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertForbidden();",
            "        \$player->refresh();",
            "        \$this->assertEquals('Old Name', \$player->name);",
            "        \$this->assertEquals('old@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertNotNull(\$player->retired_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$player));",
            "        \$response->assertForbidden();",
            "        \$player->refresh();",
            "        \$this->assertNull(\$player->retired_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_force_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$this->assertDatabaseMissing('players', ['uuid' => \$player->uuid]);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_force_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$player));",
            "        \$response->assertForbidden();",
            "        \$player->refresh();",
            "        \$this->assertNull(\$player->retired_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_restore_soft_deleted_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create(['retired_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertNull(\$player->retired_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_restore_soft_deleted_player()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create(['retired_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$player));",
            "        \$response->assertForbidden();",
            "        \$player->refresh();",
            "        \$this->assertNotNull(\$player->retired_at);",
            "    }",
            "}",
        ]), $printedClass);
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('career_goals', ModelPropertyType::INT())
                ->unsigned()
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('club_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'clubs')
                ->isRelationship('club')
            ->softDeletes(true)
            ->softDeletionColumn('retired_at')
            ->webAuthorization(false)
            ->apiAuthorization(true);

        $this->modelSupervisor->expectedExistingModels(['Club']);

        $faker = $this->fakeFaker(['name' => 'Zlatan Ibrahimovic', 'email' => 'lion@golden.com']);
        $faker->shouldReceive('randomNumber')->andReturn(130);


        $manager = new WebTestsDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new WebTestsDeveloper($manager, $this->modelSupervisor);
        $testClass = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassTemplate::class, $testClass);

        $printedClass = $testClass->print();

        $this->assertStringContainsString("namespace Tests\Feature\Web;", $printedClass);

        $this->assertStringContainsString("use App\Models\Club;", $printedClass);
        $this->assertStringContainsString("use App\Models\Player;", $printedClass);
        $this->assertStringContainsString("use App\Models\User;", $printedClass);
        $this->assertStringContainsString("use Shomisha\Crudly\Exceptions\IncompleteTestException;", $printedClass);
        $this->assertStringContainsString("use Tests\TestCase;", $printedClass);

        $this->assertStringContainsString(implode("\n", [
            "class PlayerTest extends TestCase",
            "{",
            "    public function createAndAuthenticateUser() : User",
            "    {",
            "        \$user = User::factory()->create();",
            "        \$this->be(\$user);\n",

            "        return \$user;",
            "    }\n",

            "    private function getIndexRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('index');",
            "    }\n",

            "    private function getShowRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('show');",
            "    }\n",

            "    private function getCreateRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('create');",
            "    }\n",

            "    private function getStoreRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('store');",
            "    }\n",

            "    private function getEditRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('edit');",
            "    }\n",

            "    private function getUpdateRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('update');",
            "    }\n",

            "    private function getDestroyRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('destroy');",
            "    }\n",

            "    private function getForceDeleteRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('force-delete');",
            "    }\n",

            "    private function getRestoreRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('restore');",
            "    }\n",

            "    private function getPlayerData(array \$override = []) : array",
            "    {",
            "        if (!array_key_exists('manager_id', \$override)) {",
            "            throw IncompleteTestException::provideMissingForeignKey('manager_id');",
            "        }",
            "        if (!array_key_exists('club_uuid', \$override)) {",
            "            \$override['club_uuid'] = Club::factory()->create()->uuid;",
            "        }\n",

            "        return array_merge(['name' => 'Zlatan Ibrahimovic', 'email' => 'lion@golden.com', 'career_goals' => 130], \$override);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function users_can_access_the_players_index_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$players = Player::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.index');",
            "        \$responsePlayerIds = collect(\$response->viewData('players'))->pluck('uuid');",
            "        \$this->assertCount(\$players->count(), \$responsePlayerIds);",
            "        foreach (\$players as \$player) {",
            "            \$this->assertContains(\$player->uuid, \$responsePlayerIds);",
            "        }",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function index_page_will_not_contain_soft_deleted_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$players = Player::factory()->count(5)->create();",
            "        \$player = Player::factory()->create(['retired_at' => now()]);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.index');",
            "        \$responsePlayerIds = collect(\$response->viewData('players'))->pluck('uuid');",
            "        \$this->assertNotContains(\$player->uuid, \$responsePlayerIds);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_single_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$player));",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.show');",
            "        \$responsePlayer = \$response->viewData('player');",
            "        \$this->assertTrue(\$player->is(\$responsePlayer));",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.create');",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_new_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$this->assertDatabaseHas('players', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",

            "    public function invalidPlayerDataProvider()",
            "    {",
            "        return ['Name is not a string' => ['name', false], 'Name is missing' => ['name', null], 'Email is not an email' => ['email', 'not an email'], 'Email is missing' => ['email', null], 'Career goals is not an integer' => ['career_goals', 'not an integer'], 'Career goals is missing' => ['career_goals', null], 'Manager id is not an integer' => ['manager_id', 'not an integer'], 'Manager id is missing' => ['manager_id', null], 'Club uuid is not a string' => ['club_uuid', false], 'Club uuid is missing' => ['club_uuid', null]];",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_create_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_edit_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getEditRoute(\$player));",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.edit');",
            "        \$responsePlayer = \$response->viewData('player');",
            "        \$this->assertTrue(\$player->is(\$responsePlayer));",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertEquals('New Name', \$player->name);",
            "        \$this->assertEquals('new@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_update_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$player->refresh();",
            "        \$this->assertEquals('Old Name', \$player->name);",
            "        \$this->assertEquals('old@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertNotNull(\$player->retired_at);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_force_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$this->assertDatabaseMissing('players', ['uuid' => \$player->uuid]);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_restore_soft_deleted_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$player = Player::factory()->create(['retired_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertNull(\$player->retired_at);",
            "    }",
            "}",
        ]), $printedClass);
    }

    /** @test */
    public function developer_will_omit_soft_deletion_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('career_goals', ModelPropertyType::INT())
                ->unsigned()
            ->property('manager_id', ModelPropertyType::BIG_INT())
                ->isForeign('id', 'managers')
                ->isRelationship('manager')
            ->property('club_uuid', ModelPropertyType::STRING())
                ->isForeign('uuid', 'clubs')
                ->isRelationship('club')
            ->softDeletes(false)
            ->webAuthorization(true);

        $this->modelSupervisor->expectedExistingModels(['Club']);

        $faker = $this->fakeFaker(['name' => 'Zlatan Ibrahimovic', 'email' => 'lion@golden.com']);
        $faker->shouldReceive('randomNumber')->andReturn(130);


        $manager = new WebTestsDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new WebTestsDeveloper($manager, $this->modelSupervisor);
        $testClass = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassTemplate::class, $testClass);

        $printedClass = $testClass->print();

        $this->assertStringContainsString("namespace Tests\Feature\Web;", $printedClass);

        $this->assertStringContainsString("use App\Models\Club;", $printedClass);
        $this->assertStringContainsString("use App\Models\Player;", $printedClass);
        $this->assertStringContainsString("use App\Models\User;", $printedClass);
        $this->assertStringContainsString("use Shomisha\Crudly\Exceptions\IncompleteTestException;", $printedClass);
        $this->assertStringContainsString("use Tests\TestCase;", $printedClass);

        $this->assertStringContainsString(implode("\n", [
            "class PlayerTest extends TestCase",
            "{",
            "    public function createAndAuthenticateUser() : User",
            "    {",
            "        \$user = User::factory()->create();",
            "        \$this->be(\$user);\n",

            "        return \$user;",
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

            "    private function getShowRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('show');",
            "    }\n",

            "    private function getCreateRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('create');",
            "    }\n",

            "    private function getStoreRoute() : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('store');",
            "    }\n",

            "    private function getEditRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('edit');",
            "    }\n",

            "    private function getUpdateRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('update');",
            "    }\n",

            "    private function getDestroyRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('destroy');",
            "    }\n",

            "    private function getForceDeleteRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('force-delete');",
            "    }\n",

            "    private function getRestoreRoute(Player \$player) : string",
            "    {",
            "        throw IncompleteTestException::missingRouteGetter('restore');",
            "    }\n",

            "    private function getPlayerData(array \$override = []) : array",
            "    {",
            "        if (!array_key_exists('manager_id', \$override)) {",
            "            throw IncompleteTestException::provideMissingForeignKey('manager_id');",
            "        }",
            "        if (!array_key_exists('club_uuid', \$override)) {",
            "            \$override['club_uuid'] = Club::factory()->create()->uuid;",
            "        }\n",

            "        return array_merge(['name' => 'Zlatan Ibrahimovic', 'email' => 'lion@golden.com', 'career_goals' => 130], \$override);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function users_can_access_the_players_index_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$players = Player::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.index');",
            "        \$responsePlayerIds = collect(\$response->viewData('players'))->pluck('uuid');",
            "        \$this->assertCount(\$players->count(), \$responsePlayerIds);",
            "        foreach (\$players as \$player) {",
            "            \$this->assertContains(\$player->uuid, \$responsePlayerIds);",
            "        }",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_players_index_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_single_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$player));",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.show');",
            "        \$responsePlayer = \$response->viewData('player');",
            "        \$this->assertTrue(\$player->is(\$responsePlayer));",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_player_single_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$player));",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.create');",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_visit_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_new_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$this->assertDatabaseHas('players', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",

            "    public function invalidPlayerDataProvider()",
            "    {",
            "        return ['Name is not a string' => ['name', false], 'Name is missing' => ['name', null], 'Email is not an email' => ['email', 'not an email'], 'Email is missing' => ['email', null], 'Career goals is not an integer' => ['career_goals', 'not an integer'], 'Career goals is missing' => ['career_goals', null], 'Manager id is not an integer' => ['manager_id', 'not an integer'], 'Manager id is missing' => ['manager_id', null], 'Club uuid is not a string' => ['club_uuid', false], 'Club uuid is missing' => ['club_uuid', null]];",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_create_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_users_cannot_crete_new_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$data = \$this->getPlayerData();",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_edit_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getEditRoute(\$player));",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.edit');",
            "        \$responsePlayer = \$response->viewData('player');",
            "        \$this->assertTrue(\$player->is(\$responsePlayer));",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_edit_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getEditRoute(\$player));",
            "        \$response->assertForbidden();",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$player->refresh();",
            "        \$this->assertEquals('New Name', \$player->name);",
            "        \$this->assertEquals('new@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_update_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$player->refresh();",
            "        \$this->assertEquals('Old Name', \$player->name);",
            "        \$this->assertEquals('old@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_update_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getPlayerData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$player), \$data);",
            "        \$response->assertForbidden();",
            "        \$player->refresh();",
            "        \$this->assertEquals('Old Name', \$player->name);",
            "        \$this->assertEquals('old@test.com', \$player->email);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$player));",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHas('success');",
            "        \$this->assertDatabaseMissing('players', ['uuid' => \$player->uuid]);",
            "    }\n",

            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_delete_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$player));",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseHas('players', ['uuid' => \$player->uuid]);",
            "    }",
            "}",
        ]), $printedClass);
    }

    /** @test */
    public function developer_will_delegate_helper_methods_and_test_methods_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->webAuthorization(true)
            ->softDeletes(true)
            ->softDeletionColumn('retired_at');

        $expectedMethodDevelopers = [
            'getAuthenticateUserMethodDeveloper',
            'getAuthorizeMethodDeveloper',
            'getDeauthorizeMethodDeveloper',
            'getDataMethodDeveloper',
            'getIndexTestDeveloper',
            'getIndexWillNotContainSoftDeletedModelsTestDeveloper',
            'getUnauthorizedIndexTestDeveloper',
            'getShowTestDeveloper',
            'getUnauthorizedShowTestDeveloper',
            'getCreateTestDeveloper',
            'getUnauthorizedCreateTestDeveloper',
            'getStoreTestDeveloper',
            'getInvalidDataProviderDeveloper',
            'getInvalidDataStoreTestDeveloper',
            'getUnauthorizedStoreTestDeveloper',
            'getEditTestDeveloper',
            'getUnauthorizedEditTestDeveloper',
            'getUpdateTestDeveloper',
            'getInvalidDataUpdateTestDeveloper',
            'getUnauthorizedUpdateTestDeveloper',
            'getDestroyTestDeveloper',
            'getUnauthorizedDestroyTestDeveloper',
            'getForceDeleteTestDeveloper',
            'getUnauthorizedForceDeleteTestDeveloper',
            'getRestoreTestDeveloper',
            'getUnauthorizedRestoreTestDeveloper',
        ];

        $this->manager->arraysOfDevelopers(['getRouteMethodDevelopers']);

        $this->manager->methodDevelopers($expectedMethodDevelopers);


        $developer = new WebTestsDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        foreach ($expectedMethodDevelopers as $developer) {
            $this->manager->assertMethodDeveloperRequested($developer);
        }

        $this->manager->assertArrayOfDevelopersRequested('getRouteMethodDevelopers');
    }
}
