<?php

namespace Shomisha\Crudly\Developers\Migration;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;
use Shomisha\Stubless\Values\Closure;
use Shomisha\Stubless\Values\Value;

class UpMethodDeveloper extends MigrationDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $upMethod = ClassMethod::name('up');

        return $upMethod->body(
            Block::invokeStaticMethod(
                new Importable(Schema::class),
                'create',
                [
                    $this->guessTableName($specification->getModel()),
                    $this->generateClosure($specification, $developedSet)
                ]
            )
        );
    }

    private function generateClosure(CrudlySpecification $specification, CrudlySet $developedSet): Closure
    {
        return Value::closure(
            [Argument::name('table')->type(new Importable(Blueprint::class))],
            $this->getManager()->getMigrationFieldsDeveloper()->develop($specification, $developedSet)
        );
    }
}
