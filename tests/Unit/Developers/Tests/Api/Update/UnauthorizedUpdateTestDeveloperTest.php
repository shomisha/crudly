<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Update;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Update\UnauthorizedUpdateTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Update\UnauthorizedUpdateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedUpdateTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_update_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
                ->unique()
            ->apiAuthorization(true);


        $manager = new UnauthorizedUpdateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new UnauthorizedUpdateTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_update_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$author = Author::factory()->create(['name' => 'Old Name', 'email' => 'old@test.com']);",
            "        \$data = \$this->getAuthorData(['name' => 'New Name', 'email' => 'new@test.com']);",
            "        \$response = \$this->put(\$this->getUpdateRoute(\$author), \$data);",
            "        \$response->assertForbidden();",
            "        \$author->refresh();",
            "        \$this->assertEquals('Old Name', \$author->name);",
            "        \$this->assertEquals('old@test.com', \$author->email);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
