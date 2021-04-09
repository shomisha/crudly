<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Index;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Index\IndexTestDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Index\IndexTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class IndexTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_index_method_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->apiAuthorization(true);


        $manager = new IndexTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new IndexTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_a_list_of_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->authorizeUser(\$user);",
            "        \$authors = Author::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorIds = collect(\$response->json('data'))->pluck('id');",
            "        \$this->assertCount(\$authors->count(), \$responseAuthorIds);",
            "        foreach (\$authors as \$author) {",
            "            \$this->assertContains(\$author->id, \$responseAuthorIds);",
            "        }",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }

    /** @test */
    public function developer_will_omit_authorization_if_it_was_not_requested()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->webAuthorization(true)
            ->apiAuthorization(false);


        $manager = new IndexTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new IndexTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function user_can_get_a_list_of_authors()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$authors = Author::factory()->count(5)->create();",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertStatus(200);",
            "        \$responseAuthorIds = collect(\$response->json('data'))->pluck('id');",
            "        \$this->assertCount(\$authors->count(), \$responseAuthorIds);",
            "        foreach (\$authors as \$author) {",
            "            \$this->assertContains(\$author->id, \$responseAuthorIds);",
            "        }",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
