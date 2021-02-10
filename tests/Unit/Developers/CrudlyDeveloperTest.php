<?php

namespace Shomisha\Crudly\Test\Unit\Developers;

use Shomisha\Crudly\Developers\CrudlyDeveloper;
use Shomisha\Crudly\Developers\NullClassDeveloper;
use Shomisha\Crudly\Managers\DeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\TestCase;

class CrudlyDeveloperTest extends TestCase
{
    /** @test */
    public function developer_will_develop_all_specified_application_parts()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
            'getWebCrudFormRequestDeveloper',
            'getWebCrudControllerDeveloper',
            'getWebTestsDeveloper',
            'getApiCrudFormRequestDeveloper',
            'getApiCrudApiResourceDeveloper',
            'getApiCrudControllerDeveloper',
            'getApiTestsDeveloper',
            'getPolicyTestsDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->webCrud()
            ->webAuthorization()
            ->webTests()
            ->apiCrud()
            ->apiAuthorization()
            ->apiTests();


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_web_crud_if_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectations[] = $manager->shouldNotReceive('getWebCrudControllerDeveloper');
        $expectations[] = $manager->shouldNotReceive('getWebCrudFormRequestDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->webCrud(false);


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_web_tests_if_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
            'getWebCrudFormRequestDeveloper',
            'getWebCrudControllerDeveloper',
            'getPolicyTestsDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectation[] = $manager->shouldNotReceive('getWebTestsDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->webCrud(true)
                                                          ->webAuthorization(true)
                                                          ->webTests(false);


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_web_tests_if_web_crud_was_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectations[] = $manager->shouldNotReceive('getWebTestsDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->webCrud(false)
                                                          ->webAuthorization(false)
                                                          ->webTests(true);


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_api_crud_if_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectations[] = $manager->shouldNotReceive('getApiCrudFormRequestDeveloper');
        $expectations[] = $manager->shouldNotReceive('getApiCrudApiResourceDeveloper');
        $expectations[] = $manager->shouldNotReceive('getApiCrudControllerDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->apiCrud(false);


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_api_tests_if_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
            'getApiCrudFormRequestDeveloper',
            'getApiCrudApiResourceDeveloper',
            'getApiCrudControllerDeveloper',
            'getPolicyTestsDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectations[] = $manager->shouldNotReceive('getApiTestsDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->apiCrud(true)
                                                          ->apiAuthorization(true)
                                                          ->apiTests(false);


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_api_tests_if_api_crud_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectations[] = $manager->shouldNotReceive('getApiTestsDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->apiCrud(false)
                                                          ->apiAuthorization(false)
                                                          ->apiTests(true);


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /** @test */
    public function developer_will_not_develop_policy_if_both_authorizations_were_rejected()
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
            'getWebCrudFormRequestDeveloper',
            'getWebCrudControllerDeveloper',
            'getWebTestsDeveloper',
            'getApiCrudFormRequestDeveloper',
            'getApiCrudApiResourceDeveloper',
            'getApiCrudControllerDeveloper',
            'getApiTestsDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }
        $expectations[] = $manager->shouldNotReceive('getPolicyTestsDeveloper');

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->webCrud()
                                                          ->webAuthorization(false)
                                                          ->webTests()
                                                          ->apiCrud()
                                                          ->apiAuthorization(false)
                                                          ->apiTests();


        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specificationBuilder->build());


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }

    /**
     * @test
     * @testWith ["api"]
     *           ["web"]
     */
    public function developer_will_develop_policy_if_only_one_authorization_was_accepted(string $medium)
    {
        $manager = \Mockery::mock(DeveloperManager::class);
        $expectations = [];

        foreach ([
            'getMigrationDeveloper',
            'getModelDeveloper',
            'getFactoryDeveloper',
            'getPolicyDeveloper',
        ] as $developerGetter) {
            $expectations[] = $manager->shouldReceive($developerGetter)->once()->andReturn(new NullClassDeveloper());
        }

        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
                                                          ->webAuthorization($medium === 'web')
                                                          ->apiAuthorization($medium === 'api');

        $specification = $specificationBuilder->build();

        
        $developer = new CrudlyDeveloper($manager);
        $developer->develop($specification);


        foreach ($expectations as $expectation) {
            $expectation->verify();
        }
    }
}
