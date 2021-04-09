<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Tests\Api\Index;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\Api\Methods\Index\UnauthorizedIndexTestDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Index\UnauthorizedIndexTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class UnauthorizedIndexTestDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_unauthorized_index_test()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $manager = new UnauthorizedIndexTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new UnauthorizedIndexTestDeveloper($manager, $this->modelSupervisor);
        $testMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $testMethod);

        $this->assertStringContainsString(implode("\n", [
            "    /**",
            "     * @test",
            "     */",
            "    public function unauthorized_user_cannot_get_the_authors_list()",
            "    {",
            "        \$user = \$this->createAndAuthenticateUser();",
            "        \$this->deauthorizeUser(\$user);",
            "        \$response = \$this->get(\$this->getIndexRoute());",
            "        \$response->assertForbidden();",
            "    }\n",
        ]), ClassTemplate::name('Test')->addMethod($testMethod)->print());
    }
}
