<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Authentication;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\AuthenticateAndAuthorizeUserDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\TestMethodTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AuthenticateAndAuthorizeDeveloperTest extends TestMethodTestCase
{
    /** @test */
    public function developer_can_authenticate_and_authorize_user()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Scenario')
            ->webAuthorization(true);


        $developer = new AuthenticateAndAuthorizeUserDeveloper($this->getTestMethodDeveloperManager(), $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$user = \$this->createAndAuthenticateUser();",
            "\$this->authorizeUser(\$user);",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_not_authorize_user_if_specification_does_not_require_authorization()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Scenario')
                                                          ->webAuthorization(false);


        $developer = new AuthenticateAndAuthorizeUserDeveloper($this->getTestMethodDeveloperManager(), $this->modelSupervisor);
        $printedBlock = $developer->develop($specificationBuilder->build(), new CrudlySet())->print();


        $this->assertStringContainsString(implode("\n", [
            "\$user = \$this->createAndAuthenticateUser();",
        ]), $printedBlock);
        $this->assertStringNotContainsString(implode("\n", [
            "\$this->authorizeUser(\$user);",
        ]), $printedBlock);
    }

    /** @test */
    public function developer_will_delegate_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Purchase')
            ->webAuthorization(true);

        $this->manager->imperativeCodeDevelopers([
            'getCreateAndAuthenticateUserDeveloper',
            'getAuthorizeUserDeveloper',
        ]);


        $developer = new AuthenticateAndAuthorizeUserDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getCreateAndAuthenticateUserDeveloper');
        $this->manager->assertCodeDeveloperRequested('getAuthorizeUserDeveloper');
    }
}
