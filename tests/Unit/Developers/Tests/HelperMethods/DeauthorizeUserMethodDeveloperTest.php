<?php

namespace Shomisha\Crudly\Developers\Crud\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\DeauthorizeUserMethodDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class DeauthorizeUserMethodDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_the_deauthorize_user_method()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $developer = new DeauthorizeUserMethodDeveloper($this->manager, $this->modelSupervisor);
        $method = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(ClassMethod::class, $method);
        $this->assertStringContainsString(implode("\n", [
            "    private function deauthorizeUser(User \$user) : void",
            "    {",
            "        throw IncompleteTestException::provideUserDeauthorization();",
            "    }",
        ]), ClassTemplate::name('Test')->addMethod($method)->print());
    }
}
