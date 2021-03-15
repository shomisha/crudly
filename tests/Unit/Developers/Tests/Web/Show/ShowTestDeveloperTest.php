<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Show;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Show\ShowTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Show\ShowTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ShowTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_show_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->webAuthorization(true);


        $manager = new ShowTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ShowTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->webAuthorization(false);


        $manager = new ShowTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ShowTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
