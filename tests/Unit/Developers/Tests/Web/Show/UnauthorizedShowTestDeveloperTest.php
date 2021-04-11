<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Show;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Show\UnauthorizedShowTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Show\UnauthorizedShowTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedShowTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_show_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player');


        $manager = new UnauthorizedShowTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedShowTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_access_the_player_single_page()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$player));",
            "        \$response->assertForbidden();",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
