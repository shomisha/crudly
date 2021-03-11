<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\ForceDelete;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\ForceDelete\ForceDeleteTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\ForceDelete\ForceDeleteTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ForceDeleteTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_force_delete_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at')
            ->apiAuthorization(true);


        $manager = new ForceDeleteTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ForceDeleteTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);
        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_force_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at')
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new ForceDeleteTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ForceDeleteTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_force_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getForceDeleteRoute(\$author));",
            "        \$response->assertStatus(204);",
            "        \$this->assertDatabaseMissing('authors', ['uuid' => \$author->uuid]);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
