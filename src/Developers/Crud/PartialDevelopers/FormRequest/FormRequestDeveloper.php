<?php

namespace Shomisha\Crudly\Developers\Crud\PartialDevelopers\FormRequest;

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
 * @method \Shomisha\Crudly\Managers\Crud\FormRequestDeveloperManager getManager()
 */
abstract class FormRequestDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $formRequestClass = ClassTemplate::name(
            $this->guessFormRequestClassShortName($specification->getModel())
        )->extends(new Importable(FormRequest::class));

        $formRequestClass->setNamespace($this->getFormRequestNamespace());

        $this->addFormRequestToSet($formRequestClass, $developedSet);

        $formRequestClass->withMethods([
            $this->getManager()->getAuthorizeMethodDeveloper()->develop($specification, $developedSet),
            $this->getManager()->getRulesMethodDeveloper()->develop($specification, $developedSet),
        ]);

        return $formRequestClass;
    }

    abstract protected function getFormRequestNamespace(): string;

    abstract protected function addFormRequestToSet(Code $formRequest, CrudlySet $developedSet);
}
