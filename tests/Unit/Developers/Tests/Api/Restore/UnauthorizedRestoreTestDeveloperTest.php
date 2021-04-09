<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Restore;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Restore\UnauthorizedRestoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Restore\UnauthorizedRestoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedRestoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_restore_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at')
            ->apiAuthorization(true);


        $manager = new UnauthorizedRestoreTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedRestoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_restore_soft_deleted_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create(['deleted_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertNotNull(\$author->deleted_at);",
            "    }",
        ]), ClassTemplate::name('Author')->addMethod($testMethod)->print());
    }
}
