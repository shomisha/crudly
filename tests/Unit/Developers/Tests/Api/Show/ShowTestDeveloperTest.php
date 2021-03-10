<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Show;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Show\ShowTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Show\ShowTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class ShowTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_show_method_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->apiAuthorization(true);


        $manager = new ShowTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ShowTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorId = \$response->json('data.uuid');",
            "        \$this->assertEquals(\$author->uuid, \$responseAuthorId);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_is_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new ShowTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new ShowTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_single_author()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$author = Author::factory()->create();",
            "        \$response = \$this->get(\$this->getShowRoute(\$author));",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorId = \$response->json('data.uuid');",
            "        \$this->assertEquals(\$author->uuid, \$responseAuthorId);",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
