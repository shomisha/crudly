<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Index;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Index\IndexTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Index\IndexTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class IndexTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_index_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->webAuthorization(true);


        $manager = new IndexTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new IndexTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$responsePlayerIds = \$response->viewData('players')->pluck('uuid');",
            "        \$this->assertCount(\$players->count(), \$responsePlayerIds);",
            "        foreach (\$players as \$player) {",
            "            \$this->assertContains(\$player->uuid, \$responsePlayerIds);",
            "        }",
            "    }\n",
        ]), ClassTemplate::name('Player')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->webAuthorization(false);


        $manager = new IndexTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new IndexTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$responsePlayerIds = \$response->viewData('players')->pluck('uuid');",
            "        \$this->assertCount(\$players->count(), \$responsePlayerIds);",
            "        foreach (\$players as \$player) {",
            "            \$this->assertContains(\$player->uuid, \$responsePlayerIds);",
            "        }",
            "    }\n",
        ]), ClassTemplate::name('Player')->addMethod($testMethod)->print());
    }
}
