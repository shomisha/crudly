<?php

namespace Shomisha\Crudly\Test\Unit\Developers;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudMethodDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

abstract class CrudMethodTestCase extends DeveloperTestCase
{
    abstract protected function getSpecificationBuilder(): CrudlySpecificationBuilder;

    abstract protected function getDeveloperWithManager(?BaseDeveloperManager $manager = null): CrudMethodDeveloper;

    abstract protected function getDevelopedMethodWithAuthorization(): string;

    abstract protected function getDevelopedMethodWithoutAuthorization(): string;

    /** @test */
    public function developer_will_develop_the_crud_method()
    {
        $specificationBuilder = $this->getSpecificationBuilder()
            ->webAuthorization(true)
            ->apiAuthorization(true);


        $developer = $this->getDeveloperWithManager();
        $indexMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(CrudMethod::class, $indexMethod);

        $controller = ClassTemplate::name('PostsController')->addMethod($indexMethod);
        $this->assertStringContainsString(
            $this->getDevelopedMethodWithAuthorization(),
            $controller->print()
        );
    }

    /** @test */
    public function developer_will_not_develop_authorization_block_if_authorization_was_not_requested()
    {
        $specificationBuilder = $this->getSpecificationBuilder()
            ->webAuthorization(false)
            ->apiAuthorization(false);


        $developer = $this->getDeveloperWithManager();
        $indexMethod = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(CrudMethod::class, $indexMethod);

        $controller = ClassTemplate::name('PostsController')->addMethod($indexMethod);
        $this->assertStringContainsString(
            $this->getDevelopedMethodWithoutAuthorization(),
            $controller->print()
        );
    }

    /** @test */
    public function developer_will_delegate_method_development_to_other_developers()
    {
        $specificationBuilder = $this->getSpecificationBuilder()
            ->webAuthorization(true)
            ->apiAuthorization(true);

        $expectedMethods = [
            'getLoadDeveloper',
            'getAuthorizationDeveloper',
            'getMainDeveloper',
            'getResponseDeveloper'
        ];
        $this->manager->imperativeCodeDevelopers($expectedMethods);

        $this->manager->arraysOfDevelopers([
            'getArgumentsDeveloper',
        ]);

        $developer = $this->getDeveloperWithManager($this->manager);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertArrayOfDevelopersRequested('getArgumentsDeveloper');
        foreach ($expectedMethods as $expectedMethod) {
            $this->manager->assertCodeDeveloperRequested($expectedMethod);
        }
    }

    /** @test */
    public function developer_will_not_delegate_authorization_development_if_authorization_was_not_developed()
    {
        $specificationBuilder = $this->getSpecificationBuilder()
            ->webAuthorization(false)
            ->apiAuthorization(false);

        $expectedMethods = [
            'getLoadDeveloper',
            'getMainDeveloper',
            'getResponseDeveloper'
        ];
        $this->manager->imperativeCodeDevelopers($expectedMethods);

        $this->manager->arraysOfDevelopers([
            'getArgumentsDeveloper',
        ]);


        $developer = $this->getDeveloperWithManager($this->manager);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperNotRequested('getAuthorizationDeveloper');
    }
}
