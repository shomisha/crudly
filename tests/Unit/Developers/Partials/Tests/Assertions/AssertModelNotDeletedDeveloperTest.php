<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Partials\Tests\Assertions;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\PartialDevelopers\Tests\Assertions\AssertModelNotDeletedDeveloper;
use Shomisha\Crudly\Enums\ModelPropertyType;
use Shomisha\Crudly\Managers\Tests\Api\TestMethodDeveloperManagers\Destroy\DestroyTestDeveloperManager;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\ImperativeCode\InvokeMethodBlock;

class AssertModelNotDeletedDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_can_develop_asserting_model_was_not_hard_deleted()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Developer')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(false);


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new AssertModelNotDeletedDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(InvokeMethodBlock::class, $block);
        $this->assertStringContainsString("\$this->assertDatabaseHas('developers', ['id' => \$developer->id]);", $block->print());
    }

    /** @test */
    public function developer_will_delegate_developing_model_was_not_hard_deleted_assertion_to_other_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Developer');

        $this->manager->imperativeCodeDevelopers(['getAssertNotHardDeletedDeveloper']);


        $developer = new AssertModelNotDeletedDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getAssertNotHardDeletedDeveloper');
    }

    /** @test */
    public function developer_can_develop_asserting_model_was_not_soft_deleted()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Developer')
            ->property('id', ModelPropertyType::BIG_INT())
                ->primary()
            ->softDeletes(true)
            ->softDeletionColumn('fired_at');


        $manager = new DestroyTestDeveloperManager($this->getDeveloperConfig(), $this->app);
        $developer = new AssertModelNotDeletedDeveloper($manager, $this->modelSupervisor);
        $block = $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->assertInstanceOf(Block::class, $block);
        $this->assertStringContainsString(implode("\n", [
            "\$developer->refresh();",
            "\$this->assertNull(\$developer->fired_at);",
        ]), $block->print());
    }

    /** @test */
    public function developer_will_delegate_developing_model_was_not_soft_deleted_assertion_to_other_developer()
    {
        $specificationBuilder = CrudlySpecificationBuilder::forModel('Developer')
            ->softDeletes(true)
            ->softDeletionColumn('deleted_at');

        $this->manager->imperativeCodeDevelopers(['getRefreshModelDeveloper', 'getAssertNotSoftDeletedDeveloper']);


        $developer = new AssertModelNotDeletedDeveloper($this->manager, $this->modelSupervisor);
        $developer->develop($specificationBuilder->build(), new CrudlySet());


        $this->manager->assertCodeDeveloperRequested('getRefreshModelDeveloper');
        $this->manager->assertCodeDeveloperRequested('getAssertNotSoftDeletedDeveloper');
    }
}
