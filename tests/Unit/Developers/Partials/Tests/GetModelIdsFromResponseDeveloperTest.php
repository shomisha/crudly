<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetModelIdsFromResponseDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class GetModelIdsFromResponseDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["id"]
     *           ["uuid"]
     *           ["code"]
     */
    public function developer_can_extract_model_primary_keys_from_view_response(string $primaryKey)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Author')
            ->property($primaryKey, ModelPropertyType::STRING())->primary();


        $developer = new GetModelIdsFromResponseDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString(
            "\$responseAuthorIds = \$response->viewData('authors')->pluck('{$primaryKey}');",
            $block->print()
        );
    }
}
