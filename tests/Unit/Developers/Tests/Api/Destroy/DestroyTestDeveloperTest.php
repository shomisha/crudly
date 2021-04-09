<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Destroy;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Destroy\DestroyTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy\DestroyTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class DestroyTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_delete_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('stopped_writing_at')
            ->apiAuthorization(true);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertNotNull(\$author->stopped_writing_at);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_develop_hard_deletion_test_if_soft_deletion_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(false)
            ->apiAuthorization(true);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_is_not_required()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new DestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
