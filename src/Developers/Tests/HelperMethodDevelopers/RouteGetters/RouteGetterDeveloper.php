<?php

namespace Shomisha\Crudly\Developers\Tests\HelperMethodDevelopers\RouteGetters;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Tests\TestsDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;
use Shomisha\Stubless\Utilities\Importable;

abstract class RouteGetterDeveloper extends TestsDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $method = ClassMethod::name($this->getName())->makePrivate()->return('string')->body(
            Block::throw(
                Block::invokeStaticMethod(
                    new Importable($this->incompleteWebTestExceptionName()),
                    $this->getExceptionMethodName()
                )
            )
        );

        if ($this->acceptsModelArgument()) {
            $model = $specification->getModel();

            $method->withArguments([
                Argument::name($this->guessSingularModelVariableName($model))->type(new Importable($model->getFullyQualifiedName()))
            ]);
        }

        return $method;
    }

    abstract protected function getName(): string;

    abstract protected function getExceptionMethodName(): string;

    protected function acceptsModelArgument(): bool
    {
        return false;
    }
}
