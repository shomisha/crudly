<?php

namespace Shomisha\Crudly\Developers\Crud\Api\Resource;

use Illuminate\Http\Resources\Json\JsonResource;
use Shomisha\Crudly\Contracts\Specification;
use Shomisha\Crudly\Data\CrudlySet;
use Shomisha\Crudly\Developers\Crud\CrudDeveloper;
use Shomisha\Stubless\Contracts\Code;
use Shomisha\Stubless\DeclarativeCode\ClassTemplate;
use Shomisha\Stubless\Utilities\Importable;

/**
 * Class ApiResourceDeveloper
 *
 * @method \Shomisha\Crudly\Managers\Crud\Api\ApiResourceDeveloperManager getManager()
 */
class ApiResourceDeveloper extends CrudDeveloper
{
    /** @param \Shomisha\Crudly\Specifications\CrudlySpecification $specification */
    public function develop(Specification $specification, CrudlySet $developedSet): Code
    {
        $modelName = $specification->getModel()->getName();
        $apiResourceClass = ClassTemplate::name("{$modelName}Resource")
                                         ->extends(new Importable(JsonResource::class))
                                         // TODO: make this aware of the subdomain
                                         ->setNamespace('App\Http\Resources');

        $developedSet->setApiCrudApiResource($apiResourceClass);


        $apiResourceClass->addMethod(
            $this->getManager()->getToArrayMethodDeveloper()->develop($specification, $developedSet)
        );

        return $apiResourceClass;
    }
}
