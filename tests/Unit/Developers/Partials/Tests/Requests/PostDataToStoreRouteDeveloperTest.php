<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PostDataToStoreRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store\StoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class PostDataToStoreRouteDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_sending_post_request_to_store_route()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $manager = new StoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new PostDataToStoreRouteDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$response = \$this->post(\$this->getStoreRoute(), \$data);", $block->print());
    }

    /** @test */
    public function developer_will_delegate_route_url_development_to_another_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->valueDevelopers(['getGetRouteDeveloper']);


        $developer = new PostDataToStoreRouteDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getGetRouteDeveloper');
    }
}
