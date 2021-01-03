<?php

namespace Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\Index;

use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\WebCrud\MethodDevelopers\MethodDeveloper;
use Shomisha\Crudly\Templates\Crud\Web\WebCrudMethod;
use Shomisha\Stubless\Contracts\Code;

/**
 * Class IndexDeveloper
 *
 * @method \Shomisha\Crudly\Managers\WebCrudDeveloperManager getManager()
 */
class IndexDeveloper extends MethodDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $indexMethod = new WebCrudMethod('index');
        $developedSet->getWebCrudController()->addMethod($indexMethod);

        if ($specification->hasWebAuthorization()) {
            $this->getManager()->getIndexAuthorizationDeveloper()->develop($specification, $developedSet);
        }

        $this->getManager()->getIndexMainDeveloper()->develop($specification, $developedSet);

        $this->getManager()->getIndexResponseDeveloper()->develop($specification, $developedSet);

        return $indexMethod;
    }
}
