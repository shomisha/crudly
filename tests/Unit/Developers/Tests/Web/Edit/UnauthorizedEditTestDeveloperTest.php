<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Edit;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Edit\UnauthorizedEditTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit\UnauthorizedEditTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedEditTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_develop_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player');


        $manager = new UnauthorizedEditTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedEditTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_edit_player_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getEditRoute(\$player));",
            "        \$response->assertForbidden();",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
