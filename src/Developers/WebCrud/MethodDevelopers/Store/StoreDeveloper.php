<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Store;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Crudly\Managers\BaseDeveloperManager as DeveloperManagerAbstract;
use Shomisha\Crudly\Templates\Crud\Web\WebCrudMethod;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassMethod;

/**
 * Class StoreDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class StoreDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $storeMethod = new WebCrudMethod('store');
        $developedSet->getWebCrudController()->addMethod($storeMethod);

        $this->getManager()->getStoreArgumentsDeveloper()->develop($specification, $developedSet);

        if ($specification->hasWebAuthorization()) {
            $this->getManager()->getStoreAuthorizationDeveloper()->develop($specification, $developedSet);
        }

        $this->getManager()->getStoreMainDeveloper()->develop($specification, $developedSet);
        $this->getManager()->getStoreResponseDeveloper()->develop($specification, $developedSet);

        return $storeMethod;
    }
}
