<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Create;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Create\UnauthorizedCreateTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Create\UnauthorizedCreateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedCreateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function test_can_develop_the_unauthorized_create_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->webAuthorization(true);


        $manager = new UnauthorizedCreateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new UnauthorizedCreateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_visit_the_create_new_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getCreateRoute());",
            "        \$response->assertForbidden();",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
