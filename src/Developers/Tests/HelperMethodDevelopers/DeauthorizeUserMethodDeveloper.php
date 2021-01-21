<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

class DeauthorizeUserMethodDeveloper extends TestsDeveloper
{
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        return ClassMethod::name('deauthorizeUser')
            ->makePrivate()
            ->withArguments([
                Argument::name('user')->type(new Importable($this->guessUserClass()->getFullyQualifiedName()))
            ])
            ->return('void')
            ->body(Block::throw(
                Block::invokeStaticMethod(
                    new Importable($this->incompleteWebTestExceptionName()),
                    'provideUserDeauthorization'
                )
            ));
    }
}
