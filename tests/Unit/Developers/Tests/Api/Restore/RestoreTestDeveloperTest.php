<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Restore;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Restore\RestoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Restore\RestoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class RestoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_restore_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
            ->apiAuthorization(true)
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at');


        $manager = new RestoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new RestoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_restore_soft_deleted_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['deleted_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->deleted_at);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at')
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new RestoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new RestoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_restore_soft_deleted_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create(['deleted_at' => now()]);",
            "        \$response = \$this->patch(\$this->getRestoreRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->deleted_at);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
