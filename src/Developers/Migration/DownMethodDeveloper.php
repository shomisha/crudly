<?php

namespace Shomisha\Crudly\Developers\Migration;

use Illuminate\Support\Facades\Schema;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class DownMethodDeveloper extends MigrationDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification): Code
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
