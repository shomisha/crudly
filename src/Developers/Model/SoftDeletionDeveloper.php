<?php

namespace Shomisha\Crudly\Developers\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class SoftDeletionDeveloper implements Developer
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        /** @var \Shomisha\Stubless\DeclarativeCode\ClassTemplate $model */
        $model = $developedSet->getModel();

        $model->uses([new Importable(SoftDeletes::class)]);

        if ($columnName = $specification->softDeletionColumnName()) {
            $model->addMethod(
                ClassMethod::name('getDeletedAtColumn')->makePublic()->body(Block::return($columnName))
            );
        }

        return $model;
    }
}
