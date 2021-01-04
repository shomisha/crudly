<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Show;

use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Crudly\Templates\Crud\Web\WebCrudMethod;
use Shomisha\Stubless\Contracts\Code;

/**
 * Class ShowDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class ShowDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $showMethod = new WebCrudMethod('show');
        $developedSet->getWebCrudController()->addMethod($showMethod);

        $this->getManager()->getShowArgumentsDeveloper()->develop($specification, $developedSet);
        $this->getManager()->getShowLoadDeveloper()->develop($specification, $developedSet);

        if ($specification->hasWebAuthorization()) {
            $this->getManager()->getShowAuthorizationDeveloper()->develop($specification, $developedSet);
        }

        $this->getManager()->getShowMainDeveloper()->develop($specification, $developedSet);
        $this->getManager()->getShowResponseDeveloper()->develop($specification, $developedSet);

        return $showMethod;
    }
}
