<?php

namespace Shomisha\Crudly\Test\Unit\Developers\Model;

use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Model\SoftDeletionDeveloper;
use Shomisha\Crudly\Test\Specification\CrudlySpecificationBuilder;
use Shomisha\Crudly\Test\Unit\DeveloperTestCase;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;

class SoftDeletionDeveloperTest extends DeveloperTestCase
{
    /** @test */
    public function developer_will_enable_soft_deletion_on_model()
    {
        $specification = CrudlySpecificationBuilder::forModel('Post')
            ->softDeletes()
            ->softDeletionColumn('archived_at');

        $model = ClassTemplate::name('Post');
        $this->assertStringNotContainsString("SoftDeletes", $model->print());


        $developer = new SoftDeletionDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = with(new CrudlySet())->setModel($model);
        $developer->develop($specification->build(), $developedSet);


        $printedModel = $model->print();
        $this->assertStringContainsString("use Illuminate\Database\Eloquent\SoftDeletes;", $printedModel);
        $this->assertStringContainsString(implode("\n", [
            "class Post",
            "{",
            "    use SoftDeletes;\n",

            "    public function getDeletedAtColumn()",
            "    {",
            "        return 'archived_at';",
            "    }",
            "}",
        ]), $printedModel);
    }

    /** @test */
    public function developer_will_add_soft_deletes_trait_to_model()
    {
        $specification = CrudlySpecificationBuilder::forModel('Post')
                                                   ->softDeletes()
                                                   ->softDeletionColumn('archived_at');

        $model = ClassTemplate::name('Post');
        $this->assertStringNotContainsString("use SoftDeletes;", $model->print());


        $developer = new SoftDeletionDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = with(new CrudlySet())->setModel($model);
        $developer->develop($specification->build(), $developedSet);


        $printedModel = $model->print();
        $this->assertStringContainsString("use Illuminate\Database\Eloquent\SoftDeletes;", $printedModel);
        $this->assertStringContainsString('use SoftDeletes;', $printedModel);
    }

    /** @test */
    public function developer_will_implement_the_soft_deletion_column_method_on_model()
    {
        $specification = CrudlySpecificationBuilder::forModel('Post')
                                                   ->softDeletes()
                                                   ->softDeletionColumn('deleted_at');

        $model = ClassTemplate::name('Post');
        $this->assertStringNotContainsString("use SoftDeletes;", $model->print());


        $developer = new SoftDeletionDeveloper($this->manager, $this->modelSupervisor);
        $developedSet = with(new CrudlySet())->setModel($model);
        $developer->develop($specification->build(), $developedSet);


        $printedModel = $model->print();
        $this->assertStringContainsString(implode("\n", [
            "    public function getDeletedAtColumn()",
            "    {",
            "        return 'deleted_at';",
            "    }",
        ]), $printedModel);
    }
}
