<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Authentication;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Authentication\AuthenticateAndDeauthorizeUserDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\Developers\TestMethodTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AuthenticateAndDeauthorizeDeveloperTest extends TestMethodTestCase
{
    /** @test */
    public function developer_can_implement_authenticate_and_deauthorize_user_block()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $developer = new AuthenticateAndDeauthorizeUserDeveloper($this->getTestMethodDeveloperManager(), $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$user = \$this->createAndAuthenticateUser();",
            "\$this->deauthorizeUser(\$user);",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_delegate_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Product');

        $this->manager->imperativeCodeDevelopers([
            'getCreateAndAuthenticateUserDeveloper',
            'getDeauthorizeUserDeveloper',
        ]);


        $developer = new AuthenticateAndDeauthorizeUserDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getCreateAndAuthenticateUserDeveloper');
        $this->manager->assertCodeDeveloperRequested('getDeauthorizeUserDeveloper');
    }
}
