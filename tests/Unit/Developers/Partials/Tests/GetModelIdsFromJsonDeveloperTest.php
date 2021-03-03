<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\GetModelIdsFromJsonDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class GetModelIdsFromJsonDeveloperTest extends DeveloperTestCase
{
    /**
     * @test
     * @testWith ["id"]
     *           ["uuid"]
     *           ["code"]
     */
    public function developer_can_develop_extracting_model_primary_keys_from_json(string $primaryKey)
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Post')
            ->property($primaryKey, ModelPropertyType::STRING())->primary();


        $developer = new GetModelIdsFromJsonDeveloper($this->manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $block);
        $this->assertStringContainsString(
            "\$responsePostIds = collect(\$response->json('data'))->pluck('{$primaryKey}');",
            $block->print()
        );
    }
}
