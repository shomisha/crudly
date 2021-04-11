<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Update;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Update\InvalidUpdateTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Update\InvalidUpdateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class InvalidUpdateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_invalid_update_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->webAuthorization(true);


        $manager = new InvalidUpdateTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new InvalidUpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->webAuthorization(false);


        $manager = new InvalidUpdateTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new InvalidUpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
