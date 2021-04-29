<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Load\LoadByPrimaryKeyDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\AssignBlock;

class LoadByPrimaryKeyDeveloperTest extends DeveloperTestCase
{
    public function modelsAndKeysDataProvider(): array
    {
        return [
            ['Post', 'post', 'id', 'postId'],
            ['Author', 'author', 'uuid', 'authorUuid'],
            ['Car', 'car', 'model', 'carModel'],
            ['LicensePlate', 'licensePlate', 'number', 'licensePlateNumber'],
            ['House', 'house', 'address', 'houseAddress'],
            ['Person', 'person', 'phoneNumber', 'personPhoneNumber'],
        ];
    }

    /**
     * @test
     * @dataProvider modelsAndKeysDataProvider
     */
    public function developer_can_load_models_by_primary_key(string $model, string $modelVariableName, string $primaryKeyName, string $primaryKeyVariableName)
    {
        $specification = CrudlySpecificationBuilder::forModel($model)
            ->property($primaryKeyName, ModelPropertyType::STRING())->primary()
        ->build();


        $developer = new LoadByPrimaryKeyDeveloper($this->manager, $this->modelSupervisor);
        $loadBlock = $developer->develop($specification, new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $loadBlock);
        $this->assertStringContainsString(
            "\${$modelVariableName} = {$model}::query()->withTrashed()->findOrFail(\${$primaryKeyVariableName});",
            $loadBlock->print()
        );
    }

    /**
     * @test
     * @dataProvider modelsAndKeysDataProvider
     */
    public function developer_can_skip_loading_soft_deleted_models(string $model, string $modelVariableName, string $primaryKeyName, string $primaryKeyVariableName)
    {
        $specification = CrudlySpecificationBuilder::forModel($model)
                                                   ->property($primaryKeyName, ModelPropertyType::STRING())->primary()
                                                   ->build();


        $developer = new LoadByPrimaryKeyDeveloper($this->manager, $this->modelSupervisor, false);
        $loadBlock = $developer->develop($specification, new CrudlySet());


        $this->assertInstanceOf(AssignBlock::class, $loadBlock);
        $this->assertStringContainsString(
            "\${$modelVariableName} = {$model}::query()->findOrFail(\${$primaryKeyVariableName});",
            $loadBlock->print()
        );
    }
}
