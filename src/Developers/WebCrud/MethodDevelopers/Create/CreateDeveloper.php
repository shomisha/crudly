<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Create;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Crudly\Templates\Crud\Web\WebCrudMethod;
use Shomisha\Stubless\Contracts\Code;

/**
 * Class CreateDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class CreateDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $createMethod = new WebCrudMethod('create');
        $developedSet->getWebCrudController()->addMethod($createMethod);

        $this->getManager()->getCreateLoadDeveloper()->develop($specification, $developedSet);

        if ($specification->hasWebAuthorization()) {
            $this->getManager()->getCreateAuthorizationDeveloper()->develop($specification, $developedSet);
        }

        $this->getManager()->getCreateMainDeveloper()->develop($specification, $developedSet);
        $this->getManager()->getCreateResponseDeveloper()->develop($specification, $developedSet);

        return $createMethod;
    }
}
