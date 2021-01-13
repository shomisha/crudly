<?php

namespace Shomisha\Crudly\Developers\Crud\Api\FormRequest;

use Illuminate\Foundation\Http\FormRequest;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class ApiFormRequestDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\ApiFormRequestDeveloperManager getManager()
 */
class ApiFormRequestDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $formRequestClass = ClassTemplate::name(
            $this->guessFormRequestClassShortName($specification->getModel())
        )->extends(new Importable(FormRequest::class));

        // TODO: make this domain aware?
        $formRequestClass->setNamespace("App\Http\Requests");

        $developedSet->setApiCrudFormRequest($formRequestClass);

        $formRequestClass->withMethods([
            $this->getManager()->getAuthorizeMethodDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getRulesMethodDeveloper()->develop($specification, $developedSet),
        ]);

        return $formRequestClass;
    }
}
