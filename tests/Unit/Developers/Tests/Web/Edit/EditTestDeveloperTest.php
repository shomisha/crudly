<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Edit;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Edit\EditTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit\EditTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class EditTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_edit_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->webAuthorization(true);


        $manager = new EditTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new EditTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->webAuthorization(false);


        $manager = new EditTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new EditTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
