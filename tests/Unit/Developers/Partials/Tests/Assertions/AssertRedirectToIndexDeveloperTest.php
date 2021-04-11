<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertRedirectToIndexDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Store\StoreTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertRedirectToIndexDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_response_is_redirect_to_index()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');


        $manager = new StoreTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new AssertRedirectToIndexDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$response->assertRedirect(\$this->getIndexRoute());", $block->print());
    }

    /** @test */
    public function developer_will_delegate_index_route_development_to_other_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post');

        $this->manager->valueDevelopers(['getGetRouteDeveloper']);


        $developer = new AssertRedirectToIndexDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertValueDeveloperRequested('getGetRouteDeveloper');
    }
}
