<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Update;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Update\UnauthorizedUpdateTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Update\UnauthorizedUpdateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedUpdateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_update_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL());


        $manager = new UnauthorizedUpdateTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedUpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
