<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Web\Restore;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Web\Methods\Restore\UnauthorizedRestoreTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Restore\UnauthorizedRestoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedRestoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_restore_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Player')
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at');


        $manager = new UnauthorizedRestoreTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedRestoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_restore_soft_deleted_player()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$player = Player::factory()->create(['deleted_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$player));",
            "        \$response->assertForbidden();",
            "        \$player->refresh();",
            "        \$this->assertNotNull(\$player->deleted_at);",
            "    }",
            "}",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
