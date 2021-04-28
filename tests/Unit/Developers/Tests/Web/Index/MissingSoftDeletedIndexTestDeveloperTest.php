<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Index;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\IndexWillNotContainSoftDeletedModelsTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index\IndexWillNotContainSoftDeletedModelsTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class MissingSoftDeletedIndexTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_missing_soft_deleted_at_index_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->webAuthorization(true)
            ->softDeletes(true)
            ->softDeletionColumn('retired_at');


        $manager = new IndexWillNotContainSoftDeletedModelsTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new IndexWillNotContainSoftDeletedModelsTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$responsePlayerIds = \$response->viewData('players')->pluck('id');",
            "        \$this->assertNotContains(\$player->id, \$responsePlayerIds);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_can_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->webAuthorization(false)
            ->softDeletes(true)
            ->softDeletionColumn('retired_at');


        $manager = new IndexWillNotContainSoftDeletedModelsTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new IndexWillNotContainSoftDeletedModelsTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$responsePlayerIds = \$response->viewData('players')->pluck('id');",
            "        \$this->assertNotContains(\$player->id, \$responsePlayerIds);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
