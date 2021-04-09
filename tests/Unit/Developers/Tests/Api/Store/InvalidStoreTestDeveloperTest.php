<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Store;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Store\InvalidStoreTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store\InvalidStoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class InvalidStoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_invalid_store_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->apiAuthorization(true);


        $manager = new InvalidStoreTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new InvalidStoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_create_new_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_is_not_required()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new InvalidStoreTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new InvalidStoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     * @dataProvider invalidAuthorDataProvider",
            "     */",
            "    public function user_cannot_create_new_authors_using_invalid_data(string \$field, \$value)",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$data = \$this->getAuthorData([\$field => \$value]);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertStatus(422);",
            "        \$response->assertJsonValidationErrors(\$field);",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
