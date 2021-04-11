<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Destroy;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Destroy\DestroyTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Destroy\DestroyTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class DestroyTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_destroy_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(false)
            ->webAuthorization(true);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$this->assertDatabaseMissing('players', ['id' => \$player->id]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_develop_soft_deletion_test_if_it_is_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('retired_at')
            ->webAuthorization(true);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(false)
            ->webAuthorization(false);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$this->assertDatabaseMissing('players', ['id' => \$player->id]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
