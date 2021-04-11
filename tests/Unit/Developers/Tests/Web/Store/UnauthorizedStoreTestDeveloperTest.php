<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Store;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Store\UnauthorizedStoreTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store\UnauthorizedStoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedStoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_store_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player');


        $manager = new UnauthorizedStoreTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedStoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_users_cannot_crete_new_players()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$data = \$this->getPlayerData();",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseCount('players', 0);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
