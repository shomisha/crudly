<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Requests;

use Shomisha\Crudly\Config\DeveloperConfig;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Requests\PutDataToUpdateRouteFromIndexRouteDeveloper;
use Shomisha\Crudly\Managers\Tests\Web\TestMethodDeveloperManagers\Update\UpdateTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class PutDataToUpdateRouteFromIndexRouteDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_putting_data_to_update_route_from_index_route()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author');


        $manager = new UpdateTestDeveloperManager(new DeveloperConfig(), $this->app);
        $developer = new PutDataToUpdateRouteFromIndexRouteDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);

        $this->assertStringContainsString(
            "\$response = \$this->from(\$this->getIndexRoute())->put(\$this->getUpdateRoute(\$author), \$data);",
            $block->print()
        );
    }
}
