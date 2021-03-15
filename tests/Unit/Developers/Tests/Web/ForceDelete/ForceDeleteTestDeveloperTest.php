<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\ForceDelete;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\ForceDelete\ForceDeleteTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\ForceDelete\ForceDeleteTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ForceDeleteTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_force_delete_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('retired_at')
            ->webAuthorization(true);


        $manager = new ForceDeleteTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ForceDeleteTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$this->assertDatabaseMissing('players', ['id' => \$player->id]);",
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


        $manager = new ForceDeleteTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ForceDeleteTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
            "        \$this->assertDatabaseMissing('players', ['id' => \$player->id]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
