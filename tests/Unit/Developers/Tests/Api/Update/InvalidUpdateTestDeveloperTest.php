<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Update;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Update\InvalidUpdateTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Update\InvalidUpdateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class InvalidUpdateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_invalid_update_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->apiAuthorization(true);


        $manager = new InvalidUpdateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new InvalidUpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_update_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
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


        $manager = new InvalidUpdateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new InvalidUpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_update_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertSessionHasErrors(\$field);",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
