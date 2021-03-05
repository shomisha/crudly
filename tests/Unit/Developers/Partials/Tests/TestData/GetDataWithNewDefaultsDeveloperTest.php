<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\TestData;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\TestData\GetDataWithNewDefaultsDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class GetDataWithNewDefaultsDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_getting_request_data_with_new_defaults()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property('id', ModelPropertyType::BIG_INT())
            ->property('email', ModelPropertyType::EMAIL())
            ->property('name', ModelPropertyType::STRING())
            ->property('address', ModelPropertyType::STRING());


        $developer = new GetDataWithNewDefaultsDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString("\$data = \$this->getAuthorData(['email' => 'new@test.com', 'name' => 'New Name', 'address' => 'New Street 10, New City, New Country']);", $block->print());
    }
}
