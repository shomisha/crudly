<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\LoadEditPageDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Edit\EditTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class LoadEditPageDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_loading_edit_page()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $manager = new EditTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new LoadEditPageDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$response = \$this->get(\$this->getEditRoute(\$post));", $block->print());
    }

    /** @test */
    public function developer_will_delegate_route_url_development_to_another_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->valueDevelopers(['getGetRouteDeveloper']);


        $developer = new LoadEditPageDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getGetRouteDeveloper');
    }
}
