<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Destroy;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Destroy\UnauthorizedDestroyTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy\UnauthorizedDestroyTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedDestroyTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_unauthorized_destroy_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(false);


        $manager = new UnauthorizedDestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedDestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    public function unauthorized_user_cannot_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseHas('authors', ['uuid' => \$author->uuid]);",
            "    }",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_utilize_soft_deletion_if_it_was_required()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('stopped_writing_at');


        $manager = new UnauthorizedDestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedDestroyTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    public function unauthorized_user_cannot_delete_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->delete(\$this->getDestroyRoute(\$author));",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertNull(\$author->stopped_writing_at);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
