<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Resource;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\DeclarativeCode\Argument;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager getManager() */
class ToArrayMethodDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassMethod
    {
        $method = ClassMethod::name('toArray')->withArguments([
            Argument::name('request')
        ]);

        $method->setBody(
            Block::return(
                $this->getManager()->getPropertyToResourceMappingDeveloper()->develop($specification, $developedSet)
            )
        );

        return $method;
    }
}
