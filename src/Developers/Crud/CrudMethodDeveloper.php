<?php

namespace Shomisha\Crudly\Developers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\MethodDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\Contracts\Code;

abstract class CrudMethodDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $method = new CrudMethod($this->getMethodName());

        foreach ($this->getArgumentsDevelopers() as $argumentsDeveloper) {
            $method->addArgument(
                $argumentsDeveloper->develop($specification, $developedSet)
            );
        }

        $method->withLoadBlock(
            $this->getLoadDeveloper()->develop($specification, $developedSet)
        );

        if ($this->hasAuthorization($specification)) {
            $method->withAuthorization(
                $this->getAuthorizationDeveloper()->develop($specification, $developedSet)
            );
        }

        $method->withMainBlock(
            $this->getMainDeveloper()->develop($specification, $developedSet)
        );
        $method->withResponseBlock(
            $this->getResponseDeveloper()->develop($specification, $developedSet)
        );

        return $method;
    }

    abstract protected function getMethodName(): string;

    /** @return \Shomisha\Crudly\Contracts\Developer[] */
    abstract protected function getArgumentsDevelopers(): array;

    abstract protected function getLoadDeveloper(): Developer;

    abstract protected function getAuthorizationDeveloper(): Developer;

    abstract protected function getMainDeveloper(): Developer;

    abstract protected function getResponseDeveloper(): Developer;

    abstract protected function hasAuthorization(CrudlySpecification $specification): bool;
}
