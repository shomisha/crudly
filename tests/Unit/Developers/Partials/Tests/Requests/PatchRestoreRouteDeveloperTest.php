<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PatchRestoreRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Restore\RestoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class PatchRestoreRouteDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_sending_patch_request_to_restore_route()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $manager = new RestoreTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new PatchRestoreRouteDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$response = \$this->patch(\$this->getRestoreRoute(\$post));", $block->print());
    }

    /** @test */
    public function developer_will_delegate_route_url_development_to_another_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->valueDevelopers(['getGetRouteDeveloper']);


        $developer = new PatchRestoreRouteDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getGetRouteDeveloper');
    }
}
