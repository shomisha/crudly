<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Store;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Store\StoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store\StoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class StoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_store_method_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->apiAuthorization(true);


        $manager = new StoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new StoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(201);",
            "        \$this->assertDatabaseHas('authors', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_is_not_required()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new StoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new StoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_create_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(201);",
            "        \$this->assertDatabaseHas('authors', ['name' => 'New Name', 'email' => 'new@test.com']);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
