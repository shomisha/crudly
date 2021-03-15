<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Restore;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Restore\RestoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore\RestoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class RestoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_restore_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('retired_at')
            ->webAuthorization(true);


        $manager = new RestoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new RestoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('retired_at')
            ->webAuthorization(false);


        $manager = new RestoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new RestoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
