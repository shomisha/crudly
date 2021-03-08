<?php

namespace Shomisha\Crudly\Developers\Crud\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\AuthorizeUserMethodDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class AuthorizeUserMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_authorize_user_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new AuthorizeUserMethodDeveloper($this->manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $method);
        $this->assertStringContainsString(implode("\n", [
            "    private function authorizeUser(User \$user) : void",
            "    {",
            "        throw IncompleteTestException::provideUserAuthorization();",
            "    }",
        ]), ClassTemplate::name('Test')->addMethod($method)->print());
    }
}
