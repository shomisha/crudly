<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelHasOldValuesDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;

class AssertModelHasOldValuesDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_model_has_old_values()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('User')
            ->property('name', ModelPropertyType::STRING())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('address', ModelPropertyType::STRING());


        $developer = new AssertModelHasOldValuesDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$this->assertEquals('Old Name', \$user->name);",
            "\$this->assertEquals('old@test.com', \$user->email);",
            "\$this->assertEquals('Old Street 15, Old City, Old Country', \$user->address);",
        ]), $block->print());
    }
}
