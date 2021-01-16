<?php

namespace Shomisha\Crudly\Developers\Migration;

use Illuminate\Support\Facades\Schema;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class DownMethodDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
    {
        $downMethod = ClassMethod::name('down');

        $downMethod->body(
            Block::invokeStaticMethod(
                new Importable(Schema::class),
                'dropIfExists',
                [
                    $this->guessTableName($specification->getModel())
                ]
            )
        );

        return $downMethod;
    }
}
