<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Store;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Store\StoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store\StoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class StoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_store_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->webAuthorization(true);


        $manager = new StoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new StoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->webAuthorization(false);


        $manager = new StoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new StoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
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
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
