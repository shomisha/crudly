<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Create;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Create\CreateTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create\CreateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class CreateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_create_model_tests()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->webAuthorization(true);


        $manager = new CreateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new CreateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.create');",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->webAuthorization(false)
            ->apiAuthorization(true);


        $manager = new CreateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new CreateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_access_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertSuccessful();",
            "        \$response->assertViewIs('players.create');",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
