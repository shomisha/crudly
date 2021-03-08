<?php

namespace Shomisha\Crudly\Developers\Crud\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\AuthenticateUserMethodDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class AuthenticateUserMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_authenticate_user_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $developer = new AuthenticateUserMethodDeveloper($this->manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $method);
        $this->assertStringContainsString(implode("\n", [
            "    public function createAndAuthenticateUser() : User",
            "    {",
            "        \$user = User::factory()->create();",
            "        \$this->be(\$user);\n",

            "        return \$user;",
            "    }",
        ]), ClassTemplate::name('Test')->addMethod($method)->print());
    }
}
