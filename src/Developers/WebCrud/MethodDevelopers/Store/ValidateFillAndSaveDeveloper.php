<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodBodyDeveloper;
use Shomisha\Crudly\Templates\Crud\CrudMethod;
use Shomisha\Stubless\ImperativeCode\Block;

/** @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager() */
class ValidateFillAndSaveDeveloper extends MethodBodyDeveloper
{
    protected function getMethodFromSet(CrudlySet $developedSet): CrudMethod
    {
        return $developedSet->getWebCrudController()->getMethods()['store'];
    }

    protected function performDevelopment(Specification $specification, CrudlySet $developedSet, CrudMethod $method)
    {
        $method->withMainBlock(
            Block::fromArray([
                $this->getManager()->getStoreInstantiateDeveloper()->develop($specification, $developedSet),
                $this->getManager()->getStoreValidationDeveloper()->develop($specification, $developedSet),
                $this->getManager()->getStoreFillDeveloper()->develop($specification, $developedSet),
                $this->getManager()->getStoreSaveDeveloper()->develop($specification, $developedSet),
            ])
        );
    }
}
