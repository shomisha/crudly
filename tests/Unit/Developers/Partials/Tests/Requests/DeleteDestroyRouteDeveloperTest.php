<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\DeleteDestroyRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy\DestroyTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class DeleteDestroyRouteDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_sending_delete_request_to_destroy_route()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);


        $developer = new DeleteDestroyRouteDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$response = \$this->delete(\$this->getDestroyRoute(\$post));", $block->print());
    }

    /** @test */
    public function developer_will_delegate_route_url_development_to_another_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->valueDevelopers(['getGetRouteDeveloper']);


        $developer = new DeleteDestroyRouteDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getGetRouteDeveloper');
    }
}
