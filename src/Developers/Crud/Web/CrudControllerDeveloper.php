<?php

namespace Shomisha\Crudly\Developers\Crud\Web;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class WebCrudControllerDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Web\WebCrudDeveloperManager getManager()
 */
class CrudControllerDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): ClassTemplate
    {
        $controllerClass = ClassTemplate::name($this->guessControllerName($specification))
            ->extends(new Importable(Controller::class))
            // TODO: make this domain-aware (etc. use Web, Admin, Api sub-namespaces
            ->setNamespace('App\Http\Controllers\Web');

        $developedSet->setWebCrudController($controllerClass);

        foreach ($this->getMethodDevelopers($specification) as $developer) {
            $controllerClass->addMethod($developer->develop($specification, $developedSet));
        }

        return $controllerClass;
    }

    private function guessControllerName(CrudlySpecification $specification): string
    {
        return Str::of($specification->getModel()->getName())->plural()->studly() . 'Controller';
    }

    /** @return \Shomisha\Crudly\Abstracts\Developer[] */
    private function getMethodDevelopers(CrudlySpecification $specification): array
    {
        $developers = [
            $this->getManager()->getIndexMethodDeveloper(),
            $this->getManager()->getShowMethodDeveloper(),
            $this->getManager()->getCreateMethodDeveloper(),
            $this->getManager()->getStoreMethodDeveloper(),
            $this->getManager()->getEditMethodDeveloper(),
            $this->getManager()->getUpdateMethodDeveloper(),
            $this->getManager()->getDestroyMethodDeveloper(),
        ];

        if ($specification->hasSoftDeletion()) {
            $developers[] = $this->getManager()->getForceDeleteDeveloper();
            $developers[] = $this->getManager()->getRestoreDeveloper();
        }

        return $developers;
    }
}
