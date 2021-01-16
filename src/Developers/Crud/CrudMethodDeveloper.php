<?php

namespace Shomisha\Crudly\Developers\Crud;

use Shomisha\Crudly\Contracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;

/**
 * Class CrudMethodDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\CrudMethodDeveloperManager getManager()
 */
abstract class CrudMethodDeveloper extends CrudDeveloper
{
    abstract protected function getMethodName(): string;

    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    final public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
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

    /** @return \Shomisha\Crudly\Contracts\Developer[] */
    protected function getArgumentsDevelopers(): array
    {
        return $this->getManager()->getArgumentsDeveloper();
    }

    protected function getLoadDeveloper(): Developer
    {
        return $this->getManager()->getLoadDeveloper();
    }

    protected function getAuthorizationDeveloper(): Developer
    {
        return $this->getManager()->getAuthorizationDeveloper();
    }

    protected function getMainDeveloper(): Developer
    {
        return $this->getManager()->getMainDeveloper();
    }

    protected function getResponseDeveloper(): Developer
    {
        return $this->getManager()->getResponseDeveloper();
    }

    abstract protected function hasAuthorization(CrudlySpecification $specification): bool;
}
