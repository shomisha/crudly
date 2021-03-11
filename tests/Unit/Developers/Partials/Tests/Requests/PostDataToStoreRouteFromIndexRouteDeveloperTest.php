<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PostDataToStoreRouteFromIndexRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Store\StoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class PostDataToStoreRouteFromIndexRouteDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_sending_post_request_to_store_route_from_index()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $manager = new StoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new PostDataToStoreRouteFromIndexRouteDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$response = \$this->from(\$this->getIndexRoute())->post(\$this->getStoreRoute(), \$data);", $block->print());
    }
}
