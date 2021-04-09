<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Update;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Update\UpdateTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Update\UpdateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UpdateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_implement_the_update_method_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->apiAuthorization(true);


        $manager = new UpdateTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertEquals('New Name', \$author->name);",
            "        \$this->assertEquals('new@test.com', \$author->email);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new UpdateTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(204);",
            "        \$author->refresh();",
            "        \$this->assertEquals('New Name', \$author->name);",
            "        \$this->assertEquals('new@test.com', \$author->email);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
