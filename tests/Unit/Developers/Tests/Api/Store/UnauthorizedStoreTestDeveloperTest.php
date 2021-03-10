<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Store;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Store\UnauthorizedStoreTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store\UnauthorizedStoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedStoreTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_store_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary();


        $manager = new UnauthorizedStoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new UnauthorizedStoreTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_create_new_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$data = \$this->getAuthorData([]);",
            "        \$response = \$this->post(\$this->getStoreRoute(), \$data);",
            "        \$response->assertForbidden();",
            "        \$this->assertDatabaseCount('authors', 0);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
