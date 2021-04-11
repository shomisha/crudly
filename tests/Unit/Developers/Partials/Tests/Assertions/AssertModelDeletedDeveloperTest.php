<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelDeletedDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy\DestroyTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertModelDeletedDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_model_was_hard_deleted()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Artist')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(false);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new AssertModelDeletedDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertDatabaseMissing('artists', ['uuid' => \$artist->uuid]);", $block->print());
    }

    /** @test */
    public function developer_will_delegate_hard_deletion_assertion_development_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Artist')
            ->softDeletes(false);

        $this->manager->imperativeCodeDevelopers(['getAssertHardDeletedDeveloper']);


        $developer = new AssertModelDeletedDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getAssertHardDeletedDeveloper');
    }

    /** @test */
    public function developer_can_assert_model_was_soft_deleted()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Artist')
            ->property('uuid', ModelPropertyType::STRING())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('retired_at');


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new AssertModelDeletedDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$artist->refresh();",
            "\$this->assertNotNull(\$artist->retired_at);",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_delegate_soft_deletion_assertion_to_other_developers()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Artist')
            ->softDeletes(true)
            ->softDeletionColumn('retired_at');

        $this->manager->imperativeCodeDevelopers([
            'getRefreshModelDeveloper', 'getAssertSoftDeletedDeveloper',
        ]);


        $developer = new AssertModelDeletedDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getRefreshModelDeveloper');
        $this->manager->assertCodeDeveloperRequested('getAssertSoftDeletedDeveloper');
    }
}
