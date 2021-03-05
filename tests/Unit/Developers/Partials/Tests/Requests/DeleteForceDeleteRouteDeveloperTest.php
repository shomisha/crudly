<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\DeleteForceDeleteRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\ForceDelete\ForceDeleteTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class DeleteForceDeleteRouteDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_sending_a_delete_request_to_force_delete_route()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $manager = new ForceDeleteTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new DeleteForceDeleteRouteDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$response = \$this->delete(\$this->getForceDeleteRoute(\$post));", $block->print());
    }

    /** @test */
    public function developer_will_delegate_route_url_development_to_another_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->valueDevelopers(['getGetRouteDeveloper']);


        $developer = new DeleteForceDeleteRouteDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getGetRouteDeveloper');
    }
}
