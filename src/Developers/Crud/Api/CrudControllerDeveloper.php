<?php

namespace Shomisha\Crudly\Developers\Crud\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Shomisha\Crudly\Abstracts\Developer;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Specifications\CrudlySpecification;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/** @method \Shomisha\Crudly\Managers\Crud\Api\ApiCrudDeveloperManager getManager() */
class CrudControllerDeveloper extends Developer
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $controllerClass = ClassTemplate::name($this->guessControllerName($specification))
            ->extends(new Importable(Controller::class))
            // TODO: make this configurable and domain-aware
            ->setNamespace('App\Http\Controllers\Api');

        $developedSet->setApiCrudController($controllerClass);

        foreach ($this->getMethodDevelopers($specification) as $developer) {
            $controllerClass->addMethod($developer->develop($specification, $developedSet));
        }

        return $controllerClass;
    }

    private function guessControllerName(CrudlySpecification $specification): string
    {
        return Str::of($specification->getModel()->getName())->plural()->studly() . 'Controller';
    }

    /** @return \Shomisha\Crudly\Contracts\Developer[] */
    private function getMethodDevelopers(CrudlySpecification $specification): array
    {
        $developers = [
            $this->getManager()->getIndexMethodDeveloper(),
            // $this->getManager()->getShowMethodDeveloper(),
            // $this->getManager()->getStoreMethodDeveloper(),
            // $this->getManager()->getUpdateMethodDeveloper(),
            // $this->getManager()->getDestroyMethodDeveloper(),
        ];

        if ($specification->hasSoftDeletion()) {
            // $developers[] = $this->getManager()->getForceDeleteMethodDeveloper();
            // $developers[] = $this->getManager()->getRestoreMethodDeveloper();
        }

        return $developers;
    }
}
