<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Store;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Store\InvalidStoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store\InvalidDataStoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class InvalidDataStoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_invalid_store_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->webAuthorization(true);


        $manager = new InvalidDataStoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new InvalidStoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_create_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->webAuthorization(false);


        $manager = new InvalidDataStoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new InvalidStoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     * @dataProvider invalidPlayerDataProvider",
            "     */",
            "    public function user_cannot_create_players_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getPlayerData([\$field => \$value]);",
            "        \$response = \$this->from(\$this->getIndexRoute())->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertRedirect(\$this->getIndexRoute());",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
